import { useState } from "react";
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter } from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import type { Payment } from "@/types";

interface AddPaymentModalProps {
    isOpen: boolean;
    onClose: () => void;
    onCreated?: (newPayment: Payment) => void;
}

const AddPaymentModal: React.FC<AddPaymentModalProps> = ({ isOpen, onClose, onCreated }) => {
    const [formData, setFormData] = useState<Omit<Payment, "id">>({
        email: "",
        amount: 0,
        state: "pending",
    });

    const [loading, setLoading] = useState(false);
    const [message, setMessage] = useState<{ type: "success" | "error"; text: string } | null>(null);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: name === "amount" ? parseFloat(value) : value,
        }));
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setLoading(true);
        setMessage(null);

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

        try {
            const response = await fetch("/payments", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": csrfToken || "",
                },
                credentials: "same-origin",
                body: JSON.stringify(formData),
            });

            if (response.ok) {
                const newPayment = await response.json();
                if (onCreated) {
                    onCreated(newPayment); // <- solo lo llamamos si está definido
                }
                setMessage({ type: "success", text: "Payment created successfully." });
                setTimeout(() => {
                    onClose();
                    setFormData({ email: "", amount: 0, state: "pending" });
                }, 1000);
            } else {
                const error = await response.json();
                setMessage({ type: "error", text: error.message || "Failed to create payment." });
            }
        } catch (err) {
            console.error("Error creating payment:", err);
            setMessage({ type: "error", text: "An unexpected error occurred." });
        } finally {
            setLoading(false);
        }
    };

    return (
        <Dialog open={isOpen} onOpenChange={onClose}>
            <DialogContent>
                <form onSubmit={handleSubmit}>
                    <DialogHeader>
                        <DialogTitle>Add New Payment</DialogTitle>
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
                            {loading ? "Creating..." : "Create Payment"}
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>
    );
};

export default AddPaymentModal;
