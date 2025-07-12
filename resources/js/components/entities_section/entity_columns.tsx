import { ColumnDef } from "@tanstack/react-table"
import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { Entity } from "@/types"
import { router } from "@inertiajs/react"
import { CirclePlus, Eye, Pencil, Trash2 } from "lucide-react"
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from "../ui/alert-dialog"
import { Tooltip, TooltipContent, TooltipTrigger } from "../ui/tooltip"
import { Avatar, AvatarFallback, AvatarImage } from "../ui/avatar"

type ColumnsProps = {
    onSelectEntity: (entity: Entity) => void;
};

export const columns = ({ onSelectEntity }: ColumnsProps): ColumnDef<Entity>[] => [
    {
        header: "#",
        cell: ({ row }) => <div className="font-medium">{row.index + 1}</div>,
    },
    {
        accessorKey: "nombre_razon_social",
        header: "Nombre / Razón Social",
        cell: ({ row }) => {
            const { nombre_razon_social, foto_usuario } = row.original;

            const fallback = nombre_razon_social
                .split(" ")
                .map((w) => w[0])
                .join("")
                .slice(0, 2)
                .toUpperCase();

            return (
                <div className="flex items-center gap-3">
                    <Avatar>
                        <AvatarImage
                            src={foto_usuario?.trim() ? foto_usuario : undefined}
                            alt={nombre_razon_social}
                        />
                        <AvatarFallback>{fallback}</AvatarFallback>
                    </Avatar>
                    <span className="font-medium">{nombre_razon_social}</span>
                </div>
            );
        },
    },
    {
        accessorKey: "tipo_documento_id",
        header: "Tipo Doc.",
        cell: ({ row }) => <div>{row.original.tipo_documento?.code}</div>,
    },
    {
        accessorKey: "documento",
        header: "DNI / RUC / ID",
        cell: ({ row }) => <div>{row.original.documento}</div>,
    },
    {
        accessorKey: "tipoEntidad",
        header: "Tipo Entidad",
        cell: ({ row }) => {
            const { persona, empresa } = row.original;

            const esPersona = !!persona;
            const tipo = esPersona ? "Persona" : "Empresa";

            return (
                <Badge variant={esPersona ? "default" : "secondary"}>
                    {tipo}
                </Badge>
            );
        },
    },
    {
        accessorKey: "categoria",
        header: "Categoría",
        cell: ({ row }) => {
            const tipos = row.original.tipos_entidades;

            if (!tipos || tipos.length === 0) {
                return <Badge variant="destructive">Sin categoría</Badge>;
            }

            const getAcronimo = (nombre: string): string => {
                const palabras = nombre.trim().split(/\s+/);
                if (palabras.length === 1) {
                    return palabras[0].slice(0, 2).toUpperCase();
                }
                return palabras.map(p => p[0]).join("").toUpperCase();
            };

            return (
                <div className="flex gap-1 flex-wrap justify-center items-center">
                    {tipos.map((t) => {
                        const acronimo = t.tipo?.nombre ? getAcronimo(t.tipo.nombre) : "--";
                        return (
                            <Badge key={t.id} variant="violetaTerciario">
                                {acronimo}
                            </Badge>
                        );
                    })}
                </div>
            );
        },
    },
    {
        id: "actions",
        header: "Acciones",
        cell: ({ row }) => {
            const entity = row.original
            return (
                <div className="flex justify-center gap-2">
                    {/* Botón de gestionar tipos */}
                    <Tooltip>
                        <TooltipTrigger asChild>
                            <Button
                                variant="violetaOscuro"
                                size="icon"
                                onClick={() => router.visit(`/entities/${entity.id}/create`)}
                            >
                                <CirclePlus className="w-4 h-4" />
                            </Button>
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>Gestionar Tipos</p>
                        </TooltipContent>
                    </Tooltip>

                    {/* Botón de ver detalles */}
                    <Tooltip>
                        <TooltipTrigger asChild>
                            <Button
                                variant="violetaAdaptiveBadge"
                                size="icon"
                                onClick={() => onSelectEntity(entity)}
                            >
                                <Eye className="w-4 h-4" />
                            </Button>
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>Ver Detalles</p>
                        </TooltipContent>
                    </Tooltip>

                    {/* Botón de editar */}
                    <Tooltip>
                        <TooltipTrigger asChild>
                            <Button
                                variant="violetaTerciario"
                                size="icon"
                                onClick={() => router.visit(`/entities/${entity.id}/edit`)}
                            >
                                <Pencil className="w-4 h-4" />
                            </Button>
                        </TooltipTrigger>
                        <TooltipContent>
                            <p>Editar</p>
                        </TooltipContent>
                    </Tooltip>

                    {/* Botón de eliminar con alerta */}
                    <AlertDialog>
                        <AlertDialogTrigger asChild>
                            <Button variant="violetaFuerte" size="icon">
                                <Trash2 className="w-4 h-4" />
                            </Button>
                        </AlertDialogTrigger>

                        <AlertDialogContent>
                            <AlertDialogHeader>
                                <AlertDialogTitle>¿Eliminar tipo operador?</AlertDialogTitle>
                                <AlertDialogDescription>
                                    Esta acción no se puede deshacer. Se eliminará permanentemente la
                                    entidad <strong>{entity.nombre_razon_social}</strong>.
                                </AlertDialogDescription>
                            </AlertDialogHeader>
                            <AlertDialogFooter>
                                <AlertDialogCancel>Cancelar</AlertDialogCancel>
                                <AlertDialogAction
                                    onClick={() => {
                                        router.delete(`/entities/${entity.id}`)
                                    }}
                                >
                                    Confirmar
                                </AlertDialogAction>
                            </AlertDialogFooter>
                        </AlertDialogContent>
                    </AlertDialog>
                </div >
            )
        },
    },
]
