import { useForm } from "react-hook-form"
import { z } from "zod"
import { zodResolver } from "@hookform/resolvers/zod"
import {
    Form,
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage,
} from "@/components/ui/form"
import { Input } from "@/components/ui/input"
import { Button } from "@/components/ui/button"
import { router } from "@inertiajs/react"
import type { Entity, DocumentType } from "@/types"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Textarea } from "@/components/ui/textarea"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"

const personaSchema = z.object({
    tipo: z.literal("persona"),
    foto_usuario: z.any().optional(),
    descripcion: z.string().max(1000).optional(),
    tipo_documento_id: z.coerce.number().min(1, "Tipo de documento requerido"),
    documento: z.string().min(8).max(20),
    nombre_razon_social: z.string().min(1).max(255),
    direccion: z.string().nonempty("Dirección requerida").max(255),
    pais: z.string().nonempty("País requerido").max(100),
    departamento: z.string().max(100).optional(),
    provincia: z.string().max(100).optional(),
    distrito: z.string().max(100).optional(),

    nombre_pila: z.string().min(1).max(100),
    apellido_paterno: z.string().min(1).max(100),
    apellido_materno: z.string().min(1).max(100),
    ruc: z.string().min(11).max(11),
    fecha_nacimiento: z.string().nonempty(),
    correo: z.string().email().optional(),
    genero: z.enum(["masculino", "femenino", "otro"]).optional(),
    telefono: z.string().max(20).optional(),
    codigo_postal: z.string().max(20).optional(),
})

type PersonaFormValues = z.infer<typeof personaSchema>

export default function EditPersonaForm({ entity, tipoDocumentos }: { entity: Entity, tipoDocumentos: DocumentType[] }) {
    const form = useForm<PersonaFormValues>({
        resolver: zodResolver(personaSchema),
        defaultValues: {
            tipo: "persona",
            foto_usuario: entity.foto_usuario,
            descripcion: entity.descripcion ?? "",
            tipo_documento_id: entity.tipo_documento_id,
            documento: entity.documento,
            nombre_razon_social: entity.nombre_razon_social,
            direccion: entity.direccion,
            pais: entity.pais,
            departamento: entity.departamento ?? "",
            provincia: entity.provincia ?? "",
            distrito: entity.distrito ?? "",

            nombre_pila: entity.persona?.nombre_pila ?? "",
            apellido_paterno: entity.persona?.apellido_paterno ?? "",
            apellido_materno: entity.persona?.apellido_materno ?? "",
            ruc: entity.persona?.ruc ?? "",
            fecha_nacimiento: entity.persona?.fecha_nacimiento ?? "",
            correo: entity.persona?.correo ?? "",
            genero:
                entity.persona?.genero === "masculino" ||
                    entity.persona?.genero === "femenino" ||
                    entity.persona?.genero === "otro"
                    ? entity.persona.genero
                    : undefined,
            telefono: entity.persona?.telefono ?? "",
            codigo_postal: entity.persona?.codigo_postal ?? "",
        },
    })

    const onSubmit = (data: PersonaFormValues) => {
        router.put(`/entities/${entity.id}`, data)
    }

    return (
        <div className="flex flex-col lg:flex-row w-full p-5 gap-5">
            <div className="w-full">
                <Card>
                    <CardHeader>
                        <CardTitle className="text-center">Editar Persona</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Form {...form}>
                            <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-4">
                                <hr />
                                <div className="grid grid-cols-1 lg:grid-cols-4 gap-6">
                                    <div className="col-span-1 flex flex-col gap-4">
                                        <FormField
                                            control={form.control}
                                            name="foto_usuario"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Añadir Imagen</FormLabel>
                                                    <FormControl>
                                                        <Input
                                                            type="file"
                                                            accept="image/*"
                                                            onChange={(e) => {
                                                                const file = e.target.files?.[0]
                                                                field.onChange(file)
                                                            }}
                                                        />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />

                                        <FormField
                                            control={form.control}
                                            name="descripcion"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Descripción</FormLabel>
                                                    <FormControl>
                                                        <Textarea placeholder="Ingrese descripción (opcional)" {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                    </div>
                                    <div className="col-span-1 flex flex-col gap-4">
                                        <FormField
                                            control={form.control}
                                            name="tipo_documento_id"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Tipo de Documento *</FormLabel>
                                                    <FormControl>
                                                        <Select value={String(field.value)} onValueChange={(value) => field.onChange(Number(value))}>
                                                            <SelectTrigger>
                                                                <SelectValue placeholder="Selecciona tipo de documento" />
                                                            </SelectTrigger>
                                                            <SelectContent>
                                                                {tipoDocumentos.map((td) => (
                                                                    <SelectItem key={td.id} value={String(td.id)}>
                                                                        {td.code}
                                                                    </SelectItem>
                                                                ))}
                                                            </SelectContent>
                                                        </Select>
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                        <FormField
                                            control={form.control}
                                            name="documento"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Documento *</FormLabel>
                                                    <FormControl>
                                                        <Input {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />

                                        <FormField
                                            control={form.control}
                                            name="nombre_razon_social"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Nombre / Razón Social *</FormLabel>
                                                    <FormControl>
                                                        <Input {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                    </div>
                                    <div className="col-span-1 flex flex-col gap-4">
                                        <FormField
                                            control={form.control}
                                            name="direccion"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Dirección *</FormLabel>
                                                    <FormControl>
                                                        <Input placeholder="Ingrese la dirección" {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />

                                        <FormField
                                            control={form.control}
                                            name="pais"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>País *</FormLabel>
                                                    <FormControl>
                                                        <Input placeholder="Ingrese el país" {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                    </div>
                                    <div className="col-span-1 flex flex-col gap-4">
                                        <FormField
                                            control={form.control}
                                            name="departamento"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Departamento</FormLabel>
                                                    <FormControl>
                                                        <Input placeholder="Ingrese el departamento" {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />

                                        <FormField
                                            control={form.control}
                                            name="provincia"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Provincia</FormLabel>
                                                    <FormControl>
                                                        <Input placeholder="Ingrese la provincia" {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />

                                        <FormField
                                            control={form.control}
                                            name="distrito"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Distrito</FormLabel>
                                                    <FormControl>
                                                        <Input placeholder="Ingrese el distrito" {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                    </div>
                                </div>
                                <hr />
                                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <div className="col-span-1 flex flex-col gap-4">
                                        <FormField
                                            control={form.control}
                                            name="nombre_pila"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Nombre *</FormLabel>
                                                    <FormControl>
                                                        <Input {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                        <FormField
                                            control={form.control}
                                            name="ruc"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>RUC *</FormLabel>
                                                    <FormControl>
                                                        <Input {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                        <FormField
                                            control={form.control}
                                            name="genero"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Género</FormLabel>
                                                    <FormControl>
                                                        <Select
                                                            value={field.value ?? ""}
                                                            onValueChange={field.onChange}
                                                        >
                                                            <SelectTrigger>
                                                                <SelectValue placeholder="Seleccione género" />
                                                            </SelectTrigger>
                                                            <SelectContent>
                                                                <SelectItem value="masculino">Masculino</SelectItem>
                                                                <SelectItem value="femenino">Femenino</SelectItem>
                                                                <SelectItem value="otro">Otro</SelectItem>
                                                            </SelectContent>
                                                        </Select>
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                    </div>
                                    <div className="col-span-1 flex flex-col gap-4">
                                        <FormField
                                            control={form.control}
                                            name="apellido_paterno"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Apellido Paterno *</FormLabel>
                                                    <FormControl>
                                                        <Input {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                        <FormField
                                            control={form.control}
                                            name="fecha_nacimiento"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Fecha de Nacimiento *</FormLabel>
                                                    <FormControl>
                                                        <Input type="date" {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                        <FormField
                                            control={form.control}
                                            name="telefono"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Teléfono</FormLabel>
                                                    <FormControl>
                                                        <Input type="tel" {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                    </div>
                                    <div className="col-span-1 flex flex-col gap-4">
                                        <FormField
                                            control={form.control}
                                            name="apellido_materno"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Apellido Materno *</FormLabel>
                                                    <FormControl>
                                                        <Input {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                        <FormField
                                            control={form.control}
                                            name="correo"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Correo *</FormLabel>
                                                    <FormControl>
                                                        <Input type="email" {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                        <FormField
                                            control={form.control}
                                            name="codigo_postal"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Código Postal</FormLabel>
                                                    <FormControl>
                                                        <Input {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                    </div>
                                </div>
                                <div className="flex justify-between">
                                    <Button variant="outline" type="button" asChild>
                                        <a href="/entities">Cancelar</a>
                                    </Button>
                                    <Button type="submit">Actualizar Persona</Button>
                                </div>
                            </form>
                        </Form>
                    </CardContent>
                </Card>
            </div>
        </div >
    )
}
