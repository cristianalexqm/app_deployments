import { ColumnDef } from "@tanstack/react-table"
import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { TipoRedCripto } from "@/types"
import { router } from "@inertiajs/react"
import { Pencil, Trash2 } from "lucide-react"
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "../ui/alert-dialog"

export const columns = (): ColumnDef<TipoRedCripto>[] => [
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
        accessorKey: "red",
        header: "Red",
        cell: ({ row }) => <div>{row.original.red}</div>,
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
            const red_cripto = row.original

            return (
                <div className="flex justify-center gap-2">
                    {/* Botón de editar */}
                    <Button
                        variant="outline"
                        size="icon"
                        onClick={() => router.visit(`/tipo_red_cripto/${red_cripto.id}/edit`)}
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
                                <AlertDialogTitle>¿Eliminar tipo red cripto?</AlertDialogTitle>
                                <AlertDialogDescription>
                                    Esta acción no se puede deshacer. Se eliminará permanentemente la
                                    red cripto -  <strong>{red_cripto.red}</strong>.
                                </AlertDialogDescription>
                            </AlertDialogHeader>
                            <AlertDialogFooter>
                                <AlertDialogCancel>Cancelar</AlertDialogCancel>
                                <AlertDialogAction
                                    onClick={() => {
                                        router.delete(`/tipo_red_cripto/${red_cripto.id}`)
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
