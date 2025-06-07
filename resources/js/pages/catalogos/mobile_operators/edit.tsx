import AppLayout from "@/layouts/app-layout"
import { Head, router } from "@inertiajs/react"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"
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
import type { BreadcrumbItem, MobileOperator } from "@/types"

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Catálogo", href: "#" },
    { title: "Operadores Moviles", href: "/mobile_operators" },
    { title: "Editar operador movil", href: "" },
]

const schema = z.object({
    cod: z.string().min(1, "Código requerido").max(10),
    operador: z.string().min(1, "Operador requerido").max(50),
    estado: z.boolean().optional(),
})

type FormValues = z.infer<typeof schema>

export default function EditOperadorMovilPage({ operador }: { operador: MobileOperator }) {
    const form = useForm<FormValues>({
        resolver: zodResolver(schema),
        defaultValues: {
            cod: operador.cod,
            operador: operador.operador,
            estado: operador.estado,
        },
    })

    const onSubmit = (data: FormValues) => {
        router.put(`/mobile_operators/${operador.id}`, data)
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar Operador Movil" />
            <div className="container mx-auto py-10 max-w-xl">
                <Card>
                    <CardHeader>
                        <CardTitle className="text-center">Editar operador movil</CardTitle>
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
                                    name="operador"
                                    render={({ field }) => (
                                        <FormItem>
                                            <FormLabel>Operador Movil</FormLabel>
                                            <FormControl>
                                                <Input placeholder="Ingrese el nombre del operador" {...field} />
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
                                        <a href="/mobile_operators">Cancelar</a>
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
