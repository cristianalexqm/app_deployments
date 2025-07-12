import { Card } from "@/components/ui/card";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Badge } from "@/components/ui/badge";
import { EntityProps } from "@/types";

export const EntityCard = ({ selectedEntity }: EntityProps) => {
    const getAcronimo = (nombre: string): string => {
        const palabras = nombre.trim().split(/\s+/);
        if (palabras.length === 1) {
            return palabras[0].slice(0, 2).toUpperCase();
        }
        return palabras.map(p => p[0]).join("").toUpperCase();
    };

    return (
        <Card className="p-5">
            <div className="flex flex-col items-center justify-center text-center">
                <Avatar className="w-20 h-20">
                    <AvatarImage
                        src={selectedEntity.foto_usuario}
                        alt={selectedEntity.nombre_razon_social}
                    />
                    <AvatarFallback className="text-3xl text-center">
                        {(selectedEntity.nombre_razon_social || "")
                            .split(" ")
                            .filter(Boolean) // elimina strings vacíos
                            .map(word => word[0])
                            .join("")
                            .slice(0, 2)
                            .toUpperCase()}
                    </AvatarFallback>
                </Avatar>

                <h2 className="font-semibold mt-3">
                    {selectedEntity.nombre_razon_social}
                </h2>
                <p className="text-sm text-muted-foreground">
                    {selectedEntity.persona ? "Persona" : "Empresa"}
                </p>
            </div>

            <div className="mb-0">
                <h2 className="font-bold text-sm text-center mb-1">DESCRIPCIÓN</h2>
                <p className="text-xs text-center">{selectedEntity.descripcion || "No se proporcionó descripción alguna."}</p>
            </div>

            <table className="text-sm w-full table-fixed border-separate border-spacing-y-2">
                <tbody>
                    <tr>
                        <td className="font-semibold pr-2 align-top">Tipo Documento:</td>
                        <td>{selectedEntity.tipo_documento?.code || 'N/A'}</td>
                    </tr>
                    <tr>
                        <td className="font-semibold pr-2 align-top">Documento:</td>
                        <td>{selectedEntity.documento || 'N/A'}</td>
                    </tr>

                    {selectedEntity.persona && (
                        <>
                            <tr>
                                <td className="font-semibold pr-2 align-top">RUC:</td>
                                <td>{selectedEntity.persona.ruc || 'N/A'}</td>
                            </tr>
                            <tr>
                                <td className="font-semibold pr-2 align-top">Fecha Nacimiento:</td>
                                <td>{selectedEntity.persona.fecha_nacimiento || 'N/A'}</td>
                            </tr>
                            <tr>
                                <td className="font-semibold pr-2 align-top">Correo Personal:</td>
                                <td className="break-words max-w-[140px]">{selectedEntity.persona?.correo || 'N/A'}</td>
                            </tr>
                            <tr>
                                <td className="font-semibold pr-2 align-top">Género:</td>
                                <td>{selectedEntity.persona.genero || 'N/A'}</td>
                            </tr>
                            <tr>
                                <td className="font-semibold pr-2 align-top">Teléfono:</td>
                                <td>{selectedEntity.persona.telefono || 'N/A'}</td>
                            </tr>
                            <tr>
                                <td className="font-semibold pr-2 align-top">Código Postal:</td>
                                <td>{selectedEntity.persona.codigo_postal || 'N/A'}</td>
                            </tr>
                        </>
                    )}

                    {selectedEntity.empresa && (
                        <>
                            <tr>
                                <td className="font-semibold pr-2 align-top">Correo Contacto:</td>
                                <td className="break-words max-w-[140px]">{selectedEntity.empresa.correo_contacto || 'N/A'}</td>
                            </tr>
                            <tr>
                                <td className="font-semibold pr-2 align-top">Persona Contacto:</td>
                                <td>{selectedEntity.empresa.persona_contacto || 'N/A'}</td>
                            </tr>
                            <tr>
                                <td className="font-semibold pr-2 align-top">Teléfono Contacto:</td>
                                <td>{selectedEntity.empresa.celular_contacto || 'N/A'}</td>
                            </tr>
                            <tr>
                                <td className="font-semibold pr-2 align-top">Tipo Empresa:</td>
                                <td>
                                    {selectedEntity.empresa.tipo_empresa
                                        ? selectedEntity.empresa.tipo_empresa.charAt(0).toUpperCase() +
                                        selectedEntity.empresa.tipo_empresa.slice(1)
                                        : 'N/A'}
                                </td>
                            </tr>
                        </>
                    )}

                    <tr>
                        <td className="font-semibold pr-2 align-top">Dirección:</td>
                        <td>{selectedEntity.direccion || 'N/A'}</td>
                    </tr>
                    <tr>
                        <td className="font-semibold pr-2 align-top">País:</td>
                        <td>{selectedEntity.pais || 'N/A'}</td>
                    </tr>
                    <tr>
                        <td className="font-semibold pr-2 align-top">Departamento:</td>
                        <td>{selectedEntity.departamento || 'N/A'}</td>
                    </tr>
                    <tr>
                        <td className="font-semibold pr-2 align-top">Provincia:</td>
                        <td>{selectedEntity.provincia || 'N/A'}</td>
                    </tr>
                    <tr>
                        <td className="font-semibold pr-2 align-top">Distrito:</td>
                        <td>{selectedEntity.distrito || 'N/A'}</td>
                    </tr>
                </tbody>
            </table>

            <div className="text-center">
                <h4 className="font-bold text-sm mb-1">CATEGORÍAS</h4>
                <div className="flex flex-wrap gap-2 justify-center items-center">
                    {(!selectedEntity.tipos_entidades || selectedEntity.tipos_entidades.length === 0) ? (
                        <Badge variant="destructive">Sin categoría</Badge>
                    ) : (
                        selectedEntity.tipos_entidades.map((t: any) => {
                            const acronimo = t.tipo?.nombre ? getAcronimo(t.tipo.nombre) : "--";
                            return (
                                <Badge key={t.id} variant="violetaOscuro" className="text-xs">
                                    {acronimo}
                                </Badge>
                            );
                        })
                    )}
                </div>
            </div>
        </Card>
    );
};
