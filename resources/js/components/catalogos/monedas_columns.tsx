import { ColumnDef } from "@tanstack/react-table"
import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { Currencie } from "@/types"
import { router } from "@inertiajs/react"
import { Pencil, Trash2 } from "lucide-react"
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "../ui/alert-dialog"

export const columns = (): ColumnDef<Currencie>[] => [
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
        accessorKey: "moneda",
        header: "Moneda",
        cell: ({ row }) => <div>{row.original.moneda}</div>,
    },
    {
        accessorKey: "naturaleza",
        header: "Naturaleza",
        cell: ({ row }) => {
            const nat = row.original.naturaleza
            return (
                <Badge variant={nat === "digital" ? "secondary" : "default"}>
                    {nat.charAt(0).toUpperCase() + nat.slice(1)}
                </Badge>
            )
        },
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
            const moneda = row.original

            return (
                <div className="flex justify-center gap-2">
                    {/* Botón de editar */}
                    <Button
                        variant="outline"
                        size="icon"
                        onClick={() => router.visit(`/currencies/${moneda.id}/edit`)}
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
                                <AlertDialogTitle>¿Eliminar moneda?</AlertDialogTitle>
                                <AlertDialogDescription>
                                    Esta acción no se puede deshacer. Se eliminará permanentemente la
                                    moneda <strong>{moneda.moneda}</strong>.
                                </AlertDialogDescription>
                            </AlertDialogHeader>
                            <AlertDialogFooter>
                                <AlertDialogCancel>Cancelar</AlertDialogCancel>
                                <AlertDialogAction
                                    onClick={() => {
                                        router.delete(`/currencies/${moneda.id}`)
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
