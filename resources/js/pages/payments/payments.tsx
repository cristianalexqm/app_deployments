import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { columns } from "@/components/payments/columns"
import type { Payment } from "@/types"
import { DataTable } from "@/components/payments/data-table"
import { useState } from "react";
import EditPaymentModal from '@/components/ui/EditPaymentModal';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Payments',
        href: '/payments',
    },
];

export default function PaymentsPage({ payments }: { payments: Payment[] }) {
    const [data, setData] = useState<Payment[]>(payments);

    const [editModalOpen, setEditModalOpen] = useState(false);
    const [selectedPayment, setSelectedPayment] = useState<Payment | null>(null);

    const handleUpdate = (updatedPayment: Payment) => {
        setData((prevData) =>
            prevData.map((payment) => (payment.id === updatedPayment.id ? updatedPayment : payment))
        );
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Payments" />
            <div className="container mx-auto py-10">
                <DataTable columns={columns(() => { }, setEditModalOpen, setSelectedPayment)} data={payments} />
            </div>
            <EditPaymentModal
                isOpen={editModalOpen}
                onClose={() => setEditModalOpen(false)}
                payment={selectedPayment}
                onUpdate={handleUpdate}
            />
        </AppLayout>
    );
}