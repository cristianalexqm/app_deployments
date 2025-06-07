import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import type { Currencie, SharedData } from "@/types"
import { DataTable } from '@/components/ui/data-table';
import { columns } from '@/components/catalogos/monedas_columns';
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
        title: 'Monedas',
        href: '/currencies',
    },
];

export default function MonedasPage({ monedas }: { monedas: Currencie[] }) {
    const { props } = usePage<SharedData>()
    const success = props.flash?.success
    const error = props.flash?.error

    useEffect(() => {
        if (success) toast.success(success)
        if (error) toast.error(error)
    }, [success, error])

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Monedas" />
            <div className="container mx-auto py-10">
                {/* Encabezado */}
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold text-center w-full">
                        Lista de Monedas
                    </h1>
                </div>

                <DataTable
                    columns={columns()}
                    data={monedas}
                    filterKey="moneda" // para que filtre por campo "moneda"
                    placeholder="Buscar moneda..."
                    topToolbarSlot={
                        <div className="flex gap-2">
                            <Button asChild className="flex items-center gap-1">
                                <Link href="/currencies/create">
                                    <Plus className="w-4 h-4" />
                                    Añadir moneda
                                </Link>
                            </Button>
                        </div>
                    }
                />
            </div>
        </AppLayout>
    )
}
