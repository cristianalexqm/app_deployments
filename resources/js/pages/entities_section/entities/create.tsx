import AppLayout from "@/layouts/app-layout"
import { Head, router, usePage } from "@inertiajs/react"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Card, CardHeader, CardTitle, CardContent } from "@/components/ui/card"

import {
    Form,
    FormField,
    FormItem,
    FormLabel,
    FormControl,
    FormMessage,
} from "@/components/ui/form"

import { useForm } from "react-hook-form"
import { z } from "zod"
import { zodResolver } from "@hookform/resolvers/zod"
import type { BreadcrumbItem, DocumentType } from "@/types"
import { Textarea } from "@/components/ui/textarea"
import { Popover, PopoverTrigger, PopoverContent } from "@/components/ui/popover"
import { CalendarIcon, ChevronDownIcon } from "lucide-react"
import { Calendar } from "@/components/ui/calendar"

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Directorio Personas / Empresas", href: "#" },
    { title: "Registro Personas / Empresas", href: "/entities" },
    { title: "Crear Personas / Empresas", href: "" },
];

const baseFields = {
    tipo_documento_id: z.coerce.number().min(1, "Tipo de documento requerido"),
    documento: z.string().min(8, "Documento requerido").max(20),
    nombre_razon_social: z.string().nonempty("Nombre / Razón Social requerido").max(255),
    direccion: z.string().nonempty("Dirección requerida").max(255),
    pais: z.string().nonempty("País requerido").max(100),
    departamento: z.string().max(100).optional(),
    provincia: z.string().max(100).optional(),
    distrito: z.string().max(100).optional(),
    descripcion: z.string().max(1000).optional(),
    foto_usuario: z.any().optional(),
};

const personaSchema = z.object({
    tipo: z.literal("persona"),
    ...baseFields,
    nombre_pila: z.string().nonempty("Nombre de pila requerido").max(100),
    apellido_paterno: z.string().nonempty("Apellido paterno requerido").max(100),
    apellido_materno: z.string().nonempty("Apellido materno requerido").max(100),
    ruc: z.string().nonempty("RUC requerido").min(11).max(11),
    fecha_nacimiento: z.string().nonempty("Fecha de nacimiento requerida"),
    correo: z.string().email("Correo inválido").max(255).optional(),
    genero: z.enum(["masculino", "femenino", "otro"]).optional(),
    telefono: z.string().max(20).optional(),
    codigo_postal: z.string().max(20).optional(),
});

const empresaSchema = z.object({
    tipo: z.literal("empresa"),
    ...baseFields,
    persona_contacto: z.string().nonempty("Persona de contacto requerida").max(255),
    celular_contacto: z.string().nonempty("Celular de contacto requerido").max(20),
    correo_contacto: z.string().email("Correo inválido").max(255),
    tipo_empresa: z.enum(["natural", "juridica"], { required_error: "Tipo de empresa requerido", })
});

const defaultValuesPersona: FormValues = {
    tipo: "persona",
    tipo_documento_id: 0,
    documento: "",
    nombre_razon_social: "",
    direccion: "",
    pais: "",
    departamento: "",
    provincia: "",
    distrito: "",
    descripcion: "",
    foto_usuario: undefined,
    nombre_pila: "",
    apellido_paterno: "",
    apellido_materno: "",
    ruc: "",
    fecha_nacimiento: "",
    correo: "",
    genero: undefined,
    telefono: "",
    codigo_postal: "",
};

const defaultValuesEmpresa: FormValues = {
    tipo: "empresa",
    tipo_documento_id: 0,
    documento: "",
    nombre_razon_social: "",
    direccion: "",
    pais: "",
    departamento: "",
    provincia: "",
    distrito: "",
    descripcion: "",
    foto_usuario: undefined,
    persona_contacto: "",
    celular_contacto: "",
    correo_contacto: "",
    tipo_empresa: "natural",
};


const schema = z.discriminatedUnion("tipo", [personaSchema, empresaSchema]);

type FormValues = z.infer<typeof schema>

export default function CreateEntity({ tipo, tipoDocumentos }: { tipo: "persona" | "empresa", tipoDocumentos: DocumentType[] }) {
    const form = useForm<FormValues>({
        resolver: zodResolver(schema),
        defaultValues: tipo === "persona" ? defaultValuesPersona : defaultValuesEmpresa,
    });


    const onSubmit = (data: FormValues) => {
        router.post("/entities", data)
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Nueva Entidad" />
            <div className="flex flex-col lg:flex-row w-full p-5 gap-5">
                <div className="w-full">
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-center">Crear Nueva {tipo === "persona" ? "Persona" : "Empresa"}</CardTitle>
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
                                                            <Select onValueChange={(value) => field.onChange(Number(value))}>
                                                                <SelectTrigger>
                                                                    <SelectValue placeholder="Selecciona tipo de documento" />
                                                                </SelectTrigger>
                                                                <SelectContent>
                                                                    {tipoDocumentos.map((tipoDocumentos) => (
                                                                        <SelectItem key={tipoDocumentos.id} value={String(tipoDocumentos.id)}>
                                                                            {tipoDocumentos.code}
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
                                                            <Input placeholder="Ingrese el número de documento" {...field} />
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
                                                            <Input placeholder="Ingrese el nombre o razón social" {...field} />
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
                                    {tipo === "persona" ? (
                                        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                            <div className="col-span-1 flex flex-col gap-4">
                                                <FormField
                                                    control={form.control}
                                                    name="nombre_pila"
                                                    render={({ field }) => (
                                                        <FormItem>
                                                            <FormLabel>Nombre *</FormLabel>
                                                            <FormControl>
                                                                <Input placeholder="Ingrese el nombre" {...field} />
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
                                                                <Input placeholder="Ingrese el RUC" {...field} />
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
                                                                <Input placeholder="Ingrese apellido paterno" {...field} />
                                                            </FormControl>
                                                            <FormMessage />
                                                        </FormItem>
                                                    )}
                                                />

                                                <FormField
                                                    control={form.control}
                                                    name="fecha_nacimiento"
                                                    render={({ field }) => (
                                                        <FormItem className="flex flex-col gap-2">
                                                            <FormLabel>Fecha de Nacimiento *</FormLabel>
                                                            <div className="relative">
                                                                <Input
                                                                    value={
                                                                        field.value
                                                                            ? new Date(field.value).toLocaleDateString("es-PE", {
                                                                                day: "2-digit",
                                                                                month: "long",
                                                                                year: "numeric",
                                                                            })
                                                                            : ""
                                                                    }
                                                                    onChange={() => { }} // Solo de lectura
                                                                    placeholder="Ingrese su fecha de nacimiento"
                                                                    className="pr-10"
                                                                    readOnly
                                                                />
                                                                <Popover>
                                                                    <PopoverTrigger asChild>
                                                                        <Button
                                                                            variant="ghost"
                                                                            className="absolute top-1/2 right-2 size-6 -translate-y-1/2"
                                                                        >
                                                                            <CalendarIcon className="size-4" />
                                                                            <span className="sr-only">Seleccionar fecha</span>
                                                                        </Button>
                                                                    </PopoverTrigger>
                                                                    <PopoverContent className="w-auto p-0" align="end">
                                                                        <Calendar
                                                                            mode="single"
                                                                            selected={field.value ? new Date(field.value) : undefined}
                                                                            captionLayout="dropdown"
                                                                            onSelect={(date) => {
                                                                                const formatted = date?.toISOString().split("T")[0]
                                                                                field.onChange(formatted)
                                                                            }}
                                                                            fromYear={1900}
                                                                            toYear={new Date().getFullYear()}
                                                                        />
                                                                    </PopoverContent>
                                                                </Popover>
                                                            </div>
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
                                                                <Input placeholder="Ingrese el número de teléfono" {...field} />
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
                                                                <Input placeholder="Ingrese el apellido materno" {...field} />
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
                                                                <Input placeholder="Ingrese el correo" {...field} />
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
                                                                <Input placeholder="Ingrese el código postal" {...field} />
                                                            </FormControl>
                                                            <FormMessage />
                                                        </FormItem>
                                                    )}
                                                />
                                            </div>
                                        </div>
                                    ) : (
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
                                    )}
                                    <div className="flex justify-between">
                                        <Button variant="outline" type="button" asChild>
                                            <a href="/entities">Cancelar</a>
                                        </Button>

                                        <Button type="submit">Guardar</Button>
                                    </div>
                                </form>
                            </Form>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    )
}
