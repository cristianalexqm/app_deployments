import AppLayout from "@/layouts/app-layout"
import { Head, router, usePage } from "@inertiajs/react"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
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
import type { BreadcrumbItem, QuoteProvider, SharedData, TipoRedCripto } from "@/types"
import { toast } from "sonner"
import { useEffect } from "react"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Catálogo", href: "#" },
    { title: "Tipo Red Cripto", href: "/tipo_red_cripto" },
    { title: "Editar tipo de red cripto", href: "" },
]

const schema = z.object({
    cod: z.string().min(1, "Código requerido").max(20),
    red: z.string().min(1, "Nombre de red requerido").max(50),
    estado: z.boolean().optional(),
})

type FormValues = z.infer<typeof schema>

export default function EditProveedorCuotaPage({ tipoRedCripto }: { tipoRedCripto: TipoRedCripto }) {
    const form = useForm<FormValues>({
        resolver: zodResolver(schema),
        defaultValues: {
            cod: tipoRedCripto.cod,
            red: tipoRedCripto.red,
            estado: tipoRedCripto.estado,
        },
    })

    const onSubmit = (data: FormValues) => {
        router.put(`/tipo_red_cripto/${tipoRedCripto.id}`, data)
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar Proveedor Cuota" />
            <div className="container mx-auto py-10 max-w-xl">
                <Card>
                    <CardHeader>
                        <CardTitle className="text-center">Editar proveedor cuota</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Form {...form}>
                            <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-4">
                                <FormField
                                    control={form.control}
                                    name="cod"
                                    render={({ field }) => (
                                        <FormItem>
                                            <FormLabel>Código</FormLabel>
                                            <FormControl>
                                                <Input placeholder="Ingrese el código" {...field} />
                                            </FormControl>
                                            <FormMessage />
                                        </FormItem>
                                    )}
                                />
                                <FormField
                                    control={form.control}
                                    name="red"
                                    render={({ field }) => (
                                        <FormItem>
                                            <FormLabel>Nombre</FormLabel>
                                            <FormControl>
                                                <Input placeholder="Ingrese el nombre de la red" {...field} />
                                            </FormControl>
                                            <FormMessage />
                                        </FormItem>
                                    )}
                                />

                                <FormField
                                    control={form.control}
                                    name="estado"
                                    render={({ field }) => (
                                        <FormItem>
                                            <FormLabel>Estado</FormLabel>
                                            <FormControl>
                                                <Select
                                                    value={String(field.value)} // convertimos booleano a string
                                                    onValueChange={(value) => field.onChange(value === "true")} // devolvemos booleano
                                                >
                                                    <SelectTrigger>
                                                        <SelectValue placeholder="Selecciona estado" />
                                                    </SelectTrigger>
                                                    <SelectContent>
                                                        <SelectItem value="true">Activo</SelectItem>
                                                        <SelectItem value="false">Inactivo</SelectItem>
                                                    </SelectContent>
                                                </Select>
                                            </FormControl>
                                            <FormMessage />
                                        </FormItem>
                                    )}
                                />

                                <div className="flex justify-between">
                                    <Button variant="outline" type="button" asChild>
                                        <a href="/tipo_red_cripto">Cancelar</a>
                                    </Button>
                                    <Button type="submit">Guardar cambios</Button>
                                </div>
                            </form>
                        </Form>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    )
}
