import { useForm } from "react-hook-form"
import { z } from "zod"
import { zodResolver } from "@hookform/resolvers/zod"
import { Form, FormField, FormItem, FormLabel, FormControl, FormMessage } from "@/components/ui/form"
import { Input } from "@/components/ui/input"
import { Button } from "@/components/ui/button"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { router } from "@inertiajs/react"
import type { Entity, DocumentType } from "@/types"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Textarea } from "@/components/ui/textarea"

const schema = z.object({
    tipo: z.literal("empresa"),
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
    
    persona_contacto: z.string().nonempty("Persona de contacto requerida").max(255),
    celular_contacto: z.string().nonempty("Celular de contacto requerido").max(20),
    correo_contacto: z.string().email("Correo inválido").max(255),
    tipo_empresa: z.enum(["natural", "juridica"]),
})

type FormValues = z.infer<typeof schema>

export default function EditEmpresaForm({ entity, tipoDocumentos }: { entity: Entity, tipoDocumentos: DocumentType[] }) {
    const form = useForm<FormValues>({
        resolver: zodResolver(schema),
        defaultValues: {
            tipo: "empresa",
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

            persona_contacto: entity.empresa?.persona_contacto,
            correo_contacto: entity.empresa?.correo_contacto,
            celular_contacto: entity.empresa?.celular_contacto,
            tipo_empresa:
                entity.empresa?.tipo_empresa === "natural" || entity.empresa?.tipo_empresa === "juridica"
                    ? entity.empresa.tipo_empresa
                    : "natural",
        },
    })

    const onSubmit = (data: FormValues) => {
        router.put(`/entities/${entity.id}`, data)
    }

    return (
        <div className="flex flex-col lg:flex-row w-full p-5 gap-5">
            <div className="w-full">
                <Card>
                    <CardHeader>
                        <CardTitle className="text-center">Editar Empresa</CardTitle>
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
                                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div className="col-span-1 flex flex-col gap-4">
                                        <FormField
                                            control={form.control}
                                            name="persona_contacto"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Persona de Contacto *</FormLabel>
                                                    <FormControl>
                                                        <Input placeholder="Ingrese el nombre de contacto" {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                        <FormField
                                            control={form.control}
                                            name="correo_contacto"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Correo de Contacto *</FormLabel>
                                                    <FormControl>
                                                        <Input placeholder="Ingrese el correo de contacto" {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                    </div>
                                    <div className="col-span-1 flex flex-col gap-4">
                                        <FormField
                                            control={form.control}
                                            name="celular_contacto"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Celular Contacto *</FormLabel>
                                                    <FormControl>
                                                        <Input placeholder="Ingrese el número de celular de contacto" {...field} />
                                                    </FormControl>
                                                    <FormMessage />
                                                </FormItem>
                                            )}
                                        />
                                        <FormField
                                            control={form.control}
                                            name="tipo_empresa"
                                            render={({ field }) => (
                                                <FormItem>
                                                    <FormLabel>Tipo Empresa *</FormLabel>
                                                    <FormControl>
                                                        <Select
                                                            value={field.value}
                                                            onValueChange={field.onChange}
                                                        >
                                                            <SelectTrigger>
                                                                <SelectValue placeholder="Seleccione empresa" />
                                                            </SelectTrigger>
                                                            <SelectContent>
                                                                <SelectItem value="natural">Natural</SelectItem>
                                                                <SelectItem value="juridica">Jurídica</SelectItem>
                                                            </SelectContent>
                                                        </Select>
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
                                    <Button type="submit">Actualizar Empresa</Button>
                                </div>
                            </form>
                        </Form>
                    </CardContent>
                </Card>
            </div>
        </div >
    )
}
