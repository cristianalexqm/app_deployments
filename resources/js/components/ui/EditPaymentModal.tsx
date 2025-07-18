import { useState, useEffect } from "react";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter } from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import type { Payment } from "@/types";

interface EditPaymentModalProps {
    isOpen: boolean;
    onClose: () => void;
    payment: Payment | null;
    onUpdate: (updatedPayment: Payment) => void;
}

const EditPaymentModal: React.FC<EditPaymentModalProps> = ({ isOpen, onClose, payment, onUpdate }) => {
    const [formData, setFormData] = useState<Payment>({ id: "", email: "", amount: 0, state: "pending" });
    const [message, setMessage] = useState<{ type: "success" | "error"; text: string } | null>(null);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        if (payment) {
            setFormData(payment);
        }
    }, [payment]);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setFormData((prev) => ({
            ...prev,
            [name]: name === "amount" ? parseFloat(value) : value,
        }));
    };

    const handleSubmit = async (event: React.FormEvent) => {
        event.preventDefault();
        setLoading(true);
        setMessage(null);

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

        if (!csrfToken) {
            setMessage({ type: "error", text: "CSRF token missing! Refresh the page." });
            setLoading(false);
            return;
        }

        try {
            const response = await fetch(`/payments/${formData.id}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                credentials: "same-origin",
                body: JSON.stringify(formData),
            });

            if (response.ok) {
                const updatedPayment = await response.json();
                setMessage({ type: "success", text: "Payment updated successfully!" });
                onUpdate(updatedPayment);
                setTimeout(() => {
                    onClose();
                    window.location.reload();
                }, 1500);
            } else {
                const errorData = await response.json();
                setMessage({ type: "error", text: errorData.message || "Failed to update payment." });
            }
        } catch (error) {
            console.error("Error updating payment: ", error);
            setMessage({ type: "error", text: "An error occurred. Please try again." });
        } finally {
            setLoading(false);
        }
    };

    return (
        <Dialog open={isOpen} onOpenChange={onClose}>
            <DialogContent>
                <form onSubmit={handleSubmit}>
                    <DialogHeader>
                        <DialogTitle>Edit Payment</DialogTitle>
                        {message && (
                            <div className={`p-2 rounded ${message.type === "success" ? "bg-green-200 text-green-800" : "bg-red-200 text-red-800"}`}>
                                {message.text}
                            </div>
                        )}
                        <Input
                            type="email"
                            name="email"
                            value={formData.email}
                            onChange={handleChange}
                            placeholder="Enter email"
                            required
                        />
                        <Input
                            type="number"
                            name="amount"
                            value={formData.amount}
                            onChange={handleChange}
                            placeholder="Enter amount"
                            required
                        />
                        <select
                            name="state"
                            value={formData.state}
                            onChange={handleChange}
                            className="border p-2 rounded w-full"
                            required
                        >
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="success">Success</option>
                            <option value="failed">Failed</option>
                        </select>
                    </DialogHeader>
                    <DialogFooter>
                        <Button variant="outline" type="button" onClick={onClose} disabled={loading}>
                            Cancel
                        </Button>
                        <Button type="submit" disabled={loading}>
                            {loading ? "Updating..." : "Update Payment"}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
};

export default EditPaymentModal;