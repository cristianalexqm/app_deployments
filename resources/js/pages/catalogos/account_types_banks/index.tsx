import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import type { AccountTypeBanks, SharedData } from "@/types"
import { DataTable } from '@/components/ui/data-table';
import { columns } from '@/components/catalogos/tipo_cuentas_bancos_columns';
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
        title: 'Tipos Cuentas Bancos',
        href: '/account_types_banks',
    },
];

export default function TipoCuentaBancoPage({ tipos_cuentas }: { tipos_cuentas: AccountTypeBanks[] }) {
    const { props } = usePage<SharedData>()
    const success = props.flash?.success
    const error = props.flash?.error

    useEffect(() => {
        if (success) toast.success(success)
        if (error) toast.error(error)
    }, [success, error])

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tipos Cuentas Bancos" />
            <div className="container mx-auto py-10">
                {/* Encabezado */}
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold text-center w-full">
                        Lista de Tipos Cuentas Bancos
                    </h1>
                </div>

                <DataTable
                    columns={columns()}
                    data={tipos_cuentas}
                    filterKey="tipo_cuenta" // para que filtre por campo "tipo_cuenta"
                    placeholder="Buscar tipo de cuenta banco..."
                    topToolbarSlot={
                        <div className="flex gap-2">
                            <Button asChild className="flex items-center gap-1">
                                <Link href="/account_types_banks/create">
                                    <Plus className="w-4 h-4" />
                                    Añadir Tipo Cuenta Banco
                                </Link>
                            </Button>
                        </div>
                    }
                />
            </div>
        </AppLayout>
    )
}
