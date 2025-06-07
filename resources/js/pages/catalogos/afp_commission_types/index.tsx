import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import type { AfpCommissionType, AfpType, SharedData } from "@/types"
import { DataTable } from '@/components/ui/data-table';
import { columns } from '@/components/catalogos/afp_commision_type_columns';
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
        title: 'Tipo de Comisión AFP',
        href: '/afp_commision_types',
    },
];

export default function AfpCommissionTypePage({ afpCommissionTypes }: { afpCommissionTypes: AfpCommissionType[] }) {
    const { props } = usePage<SharedData>()
    const success = props.flash?.success
    const error = props.flash?.error

    useEffect(() => {
        if (success) toast.success(success)
        if (error) toast.error(error)
    }, [success, error])

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tipo Comisión AFP" />
            <div className="container mx-auto py-10">
                {/* Encabezado */}
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold text-center w-full">
                        Lista de Tipos de Comisión de AFP
                    </h1>
                </div>

                <DataTable
                    columns={columns()}
                    data={afpCommissionTypes}
                    filterKey="nombre" // para que filtre por campo "nombre"
                    placeholder="Buscar tipo comisión AFP..."
                    topToolbarSlot={
                        <div className="flex gap-2">
                            <Button asChild className="flex items-center gap-1">
                                <Link href="/afp_commission_types/create">
                                    <Plus className="w-4 h-4" />
                                    Añadir Tipo Comisión AFP
                                </Link>
                            </Button>
                        </div>
                    }
                />
            </div>
        </AppLayout>
    )
}
