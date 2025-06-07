import { ColumnDef } from "@tanstack/react-table"
import { Button } from "@/components/ui/button"
import { QuoteProvider } from "@/types"
import { router } from "@inertiajs/react"
import { Pencil, Trash2 } from "lucide-react"
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "../ui/alert-dialog"

export const columns = (): ColumnDef<QuoteProvider>[] => [
    {
        header: "#",
        cell: ({ row }) => <div className="font-medium">{row.index + 1}</div>,
    },
    {
        accessorKey: "nombre",
        header: "Nombre",
        cell: ({ row }) => <div className="font-medium">{row.original.nombre}</div>,
    },
    {
        accessorKey: "descripcion",
        header: "Descripción",
        cell: ({ row }) => <div>{row.original.descripcion ?? "No se proporciono descripción"}</div>,
    },
    {
        id: "actions",
        header: "Acciones",
        cell: ({ row }) => {
            const quote_providers = row.original

            return (
                <div className="flex justify-center gap-2">
                    {/* Botón de editar */}
                    <Button
                        variant="outline"
                        size="icon"
                        onClick={() => router.visit(`/quote_providers/${quote_providers.id}/edit`)}
                    >
                        <Pencil className="w-4 h-4" />
                    </Button>

                    {/* Botón de eliminar con alerta */}
                    <AlertDialog>
                        <AlertDialogTrigger asChild>
                            <Button variant="destructive" size="icon">
                                <Trash2 className="w-4 h-4" />
                            </Button>
                        </AlertDialogTrigger>

                        <AlertDialogContent>
                            <AlertDialogHeader>
                                <AlertDialogTitle>¿Eliminar proveedor de cuota?</AlertDialogTitle>
                                <AlertDialogDescription>
                                    Esta acción no se puede deshacer. Se eliminará permanentemente el proveedor <strong>{quote_providers.nombre}</strong>.
                                </AlertDialogDescription>
                            </AlertDialogHeader>
                            <AlertDialogFooter>
                                <AlertDialogCancel>Cancelar</AlertDialogCancel>
                                <AlertDialogAction
                                    onClick={() => {
                                        router.delete(`/quote_providers/${quote_providers.id}`)
                                    }}
                                >
                                    Confirmar
                                </AlertDialogAction>
                            </AlertDialogFooter>
                        </AlertDialogContent>
                    </AlertDialog>
                </div>
            )
        },
    },
]
