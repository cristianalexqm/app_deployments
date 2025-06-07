import { ColumnDef } from "@tanstack/react-table"
import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { MobileOperator } from "@/types"
import { router } from "@inertiajs/react"
import { Pencil, Trash2 } from "lucide-react"
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "../ui/alert-dialog"

export const columns = (): ColumnDef<MobileOperator>[] => [
    {
        header: "#",
        cell: ({ row }) => <div className="font-medium">{row.index + 1}</div>,
    },
    {
        accessorKey: "cod",
        header: "Código",
        cell: ({ row }) => <div className="font-medium">{row.original.cod}</div>,
    },
    {
        accessorKey: "operador",
        header: "Operador",
        cell: ({ row }) => <div>{row.original.operador}</div>,
    },
    {
        accessorKey: "estado",
        header: "Estado",
        cell: ({ row }) => {
            const estado = row.original.estado
            return (
                <Badge variant={estado ? "default" : "destructive"}>
                    {estado ? "Activo" : "Inactivo"}
                </Badge>
            )
        },
    },
    {
        id: "actions",
        header: "Acciones",
        cell: ({ row }) => {
            const operador_movil = row.original

            return (
                <div className="flex justify-center gap-2">
                    {/* Botón de editar */}
                    <Button
                        variant="outline"
                        size="icon"
                        onClick={() => router.visit(`/mobile_operators/${operador_movil.id}/edit`)}
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
                                <AlertDialogTitle>¿Eliminar tipo operador?</AlertDialogTitle>
                                <AlertDialogDescription>
                                    Esta acción no se puede deshacer. Se eliminará permanentemente el
                                    operador <strong>{operador_movil.operador}</strong>.
                                </AlertDialogDescription>
                            </AlertDialogHeader>
                            <AlertDialogFooter>
                                <AlertDialogCancel>Cancelar</AlertDialogCancel>
                                <AlertDialogAction
                                    onClick={() => {
                                        router.delete(`/mobile_operators/${operador_movil.id}`)
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
