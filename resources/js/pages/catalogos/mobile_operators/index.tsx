import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import type { MobileOperator, SharedData } from "@/types"
import { DataTable } from '@/components/ui/data-table';
import { columns } from '@/components/catalogos/operadores_moviles_columns';
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
        title: 'Operadores Moviles',
        href: '/mobile_operators',
    },
];

export default function OperadorMovilPage({ operadores }: { operadores: MobileOperator[] }) {
    const { props } = usePage<SharedData>()
    const success = props.flash?.success
    const error = props.flash?.error

    useEffect(() => {
        if (success) toast.success(success)
        if (error) toast.error(error)
    }, [success, error])

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Operadores Moviles" />
            <div className="container mx-auto py-10">
                {/* Encabezado */}
                <div className="flex items-center justify-between">
                    <h1 className="text-2xl font-bold text-center w-full">
                        Lista de Operadores Moviles
                    </h1>
                </div>

                <DataTable
                    columns={columns()}
                    data={operadores}
                    filterKey="operador" // para que filtre por campo "operador"
                    placeholder="Buscar operador..."
                    topToolbarSlot={
                        <div className="flex gap-2">
                            <Button asChild className="flex items-center gap-1">
                                <Link href="/mobile_operators/create">
                                    <Plus className="w-4 h-4" />
                                    Añadir Operador Movil
                                </Link>
                            </Button>
                        </div>
                    }
                />
            </div>
        </AppLayout>
    )
}
