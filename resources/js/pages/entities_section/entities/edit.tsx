import AppLayout from "@/layouts/app-layout"
import { Head } from "@inertiajs/react"
import type { BreadcrumbItem, DocumentType, Entity } from "@/types"
import EditPersonaForm from "./EditPersonaForm"
import EditEmpresaForm from "./EditEmpresaForm"

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Directorio Personas / Empresas", href: "#" },
    { title: "Registro Personas / Empresas", href: "/entities" },
    { title: "Editar Personas / Empresas", href: "" },
]

export default function EditEntityPage({
    entity,
    tipo,
    tipoDocumentos,
}: {
    entity: Entity
    tipo: "persona" | "empresa"
    tipoDocumentos: DocumentType[]
}) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Editar ${tipo === "persona" ? "Persona" : "Empresa"}`} />
            {tipo === "persona" ? (
                <EditPersonaForm entity={entity} tipoDocumentos={tipoDocumentos}/>
            ) : (
                <EditEmpresaForm entity={entity} tipoDocumentos={tipoDocumentos} />
            )}
        </AppLayout>
    )
}
