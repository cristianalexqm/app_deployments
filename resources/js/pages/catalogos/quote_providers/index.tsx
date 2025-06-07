import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import type { DocumentType, QuoteProvider, SharedData } from "@/types"
import { DataTable } from '@/components/ui/data-table';
import { columns } from '@/components/catalogos/proveedor_cuota_columns';
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
        title: 'Proveedor Cuota',
        href: '/quote_providers',
    },
];

export default function ProveedorCuotaPage({ providers }: { providers: QuoteProvider[] }) {
    const { props } = usePage<SharedData>()
    const success = props.flash?.success
    const error = props.flash?.error

    useEffect(() => {
        if (success) toast.success(success)
        if (error) toast.error(error)
    }, [success, error])

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Proveedor Cuota" />
            <div className="container mx-auto py-10">
                {/* Encabezado */}
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold text-center w-full">
                        Lista de Proveedor Cuota
                    </h1>
                </div>

                <DataTable
                    columns={columns()}
                    data={providers}
                    filterKey="nombre" // para que filtre por campo "nombre"
                    placeholder="Buscar nombre proveedor..."
                    topToolbarSlot={
                        <div className="flex gap-2">
                            <Button asChild className="flex items-center gap-1">
                                <Link href="/quote_providers/create">
                                    <Plus className="w-4 h-4" />
                                    Añadir Proveedor Cuota
                                </Link>
                            </Button>
                        </div>
                    }
                />
            </div>
        </AppLayout>
    )
}
