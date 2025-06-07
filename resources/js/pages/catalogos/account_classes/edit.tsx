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
import type { AccountClasses, BreadcrumbItem } from "@/types"

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Catálogo", href: "#" },
    { title: "Tipo de Clase Cuenta", href: "/account_classes" },
    { title: "Editar tipo de clase cuenta", href: "" },
]

const schema = z.object({
    cod: z.string().min(1, "Código requerido").max(10),
    tipo_clase_cuenta: z.string().min(1, "Tipo de clase cuenta requerido").max(50),
    estado: z.boolean().optional(),
})

type FormValues = z.infer<typeof schema>

export default function EditClaseCuentaPage({ clase }: { clase: AccountClasses }) {
    const form = useForm<FormValues>({
        resolver: zodResolver(schema),
        defaultValues: {
            cod: clase.cod,
            tipo_clase_cuenta: clase.tipo_clase_cuenta,
            estado: clase.estado,
        },
    })

    const onSubmit = (data: FormValues) => {
        router.put(`/account_classes/${clase.id}`, data)
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar Tipo Clase Cuenta" />
            <div className="container mx-auto py-10 max-w-xl">
                <Card>
                    <CardHeader>
                        <CardTitle className="text-center">Editar tipo de clase cuenta</CardTitle>
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
                                    name="tipo_clase_cuenta"
                                    render={({ field }) => (
                                        <FormItem>
                                            <FormLabel>Tipo de Clase Cuenta</FormLabel>
                                            <FormControl>
                                                <Input placeholder="Ingrese el nombre del tipo de clase cuenta" {...field} />
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
                                        <a href="/account_classes">Cancelar</a>
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
