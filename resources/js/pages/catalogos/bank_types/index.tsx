import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import type { BankType, SharedData } from "@/types"
import { DataTable } from '@/components/ui/data-table';
import { columns } from '@/components/catalogos/tipo_bancos_columns';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-react';
import { Link } from "@inertiajs/react"

import { useEffect } from "react"
import { toast } from "sonner"

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Catalogo',
        href: '',
    },
    {
        title: 'Tipos Bancos',
        href: '/bank_types',
    },
];

export default function TiposBancosPage({ tipos_bancos }: { tipos_bancos: BankType[] }) {
    const { props } = usePage<SharedData>()
    const success = props.flash?.success
    const error = props.flash?.error

    useEffect(() => {
        if (success) toast.success(success)
        if (error) toast.error(error)
    }, [success, error])

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tipos Bancos" />
            <div className="container mx-auto py-10">
                {/* Encabezado */}
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold text-center w-full">
                        Lista de Tipos Bancos
                    </h1>
                </div>

                <DataTable
                    columns={columns()}
                    data={tipos_bancos}
                    filterKey="tipo_banco" // para que filtre por campo "tipo_banco"
                    placeholder="Buscar tipo banco..."
                    topToolbarSlot={
                        <div className="flex gap-2">
                            <Button asChild className="flex items-center gap-1">
                                <Link href="/bank_types/create">
                                    <Plus className="w-4 h-4" />
                                    Añadir Tipo Banco
                                </Link>
                            </Button>
                        </div>
                    }
                />
            </div>
        </AppLayout>
    )
}
