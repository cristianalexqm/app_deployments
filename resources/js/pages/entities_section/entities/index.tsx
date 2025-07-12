import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import type { Entity, SharedData } from "@/types"
import { DataTable } from '@/components/ui/data-table';
import { columns } from '@/components/entities_section/entity_columns';
import { Button } from '@/components/ui/button';
import { Plus } from 'lucide-react';
import { Link } from "@inertiajs/react"

import { useEffect } from "react"
import { toast } from "sonner"
import { Card } from '@/components/ui/card';

import { useState } from 'react';
import { EntityCard } from '@/components/entities_section/entity_card';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Directorio Personas / Empresas',
        href: '',
    },
    {
        title: 'Registro Personas / Empresas',
        href: '/entities',
    },
];

export default function EntitiesPage({ entities }: { entities: Entity[] }) {
    const { props } = usePage<SharedData>()
    const success = props.flash?.success
    const error = props.flash?.error

    const [selectedEntity, setSelectedEntity] = useState<Entity | null>(null);

    useEffect(() => {
        if (success) toast.success(success)
        if (error) toast.error(error)
    }, [success, error])

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Lista de Entidades" />

            <div className="flex flex-col lg:flex-row w-full p-5 gap-5">
                <div className="lg:w-3/4 w-full">
                    {/* Sección principal */}
                    <Card className='py-0'>
                        <DataTable
                            columns={columns({ onSelectEntity: setSelectedEntity })}
                            data={entities}
                            filterKey="nombre_razon_social" // para que filtre por campo "nombre_razon_social"
                            placeholder="Buscar por nombre entidad..."
                            topToolbarSlot={
                                <div className="flex gap-2">
                                    <Button asChild className="flex items-center gap-1" variant="violetaSecundario">
                                        <Link href="/entities/create?tipo=persona">
                                            <Plus className="w-4 h-4" />
                                            Añadir Persona
                                        </Link>
                                    </Button>

                                    <Button asChild className="flex items-center gap-1" variant="violetaSecundario">
                                        <Link href="/entities/create?tipo=empresa">
                                            <Plus className="w-4 h-4" />
                                            Añadir Empresa
                                        </Link>
                                    </Button>
                                </div>
                            }
                        />
                    </Card>
                </div>
                <div className="lg:w-1/4 w-full">
                    {/* Sección secundaria */}
                    {!selectedEntity ? (
                        <Card className="p-6 flex flex-col items-center justify-center text-center h-full">
                            <div className="text-sm">
                                <p className="mb-2">Presione el botón</p>
                                <p className="font-semibold">"Ver Detalles"</p>
                                <p className="mt-2">para mostrar información de una persona o empresa.</p>
                            </div>
                        </Card>
                    ) : (
                        <EntityCard selectedEntity={selectedEntity} />
                    )}
                </div>
            </div>
        </AppLayout>
    )
}