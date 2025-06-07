import AppLayout from "@/layouts/app-layout"
import { Head, router } from "@inertiajs/react"
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
import type { BreadcrumbItem } from "@/types"

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Catálogo", href: "#" },
    { title: "Tipos Cuentas Bancos", href: "/account_types_banks" },
    { title: "Crear tipo cuenta banco", href: "" },
]

const schema = z.object({
    cod: z.string().min(1, "Código requerido").max(10),
    tipo_cuenta: z.string().min(1, "Tipo de cuenta banco requerido").max(50),
})

type FormValues = z.infer<typeof schema>

export default function CreateTipoTarjetaPage() {
    const form = useForm<FormValues>({
        resolver: zodResolver(schema),
        defaultValues: {
            cod: "",
            tipo_cuenta: "",
        },
    })

    const onSubmit = (data: FormValues) => {
        router.post("/account_types_banks", data)
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Tipo Cuenta Banco" />
            <div className="container mx-auto py-10 max-w-xl">
                <Card>
                    <CardHeader>
                        <CardTitle className="text-center">Registrar nuevo tipo de cuenta de banco</CardTitle>
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
                                    name="tipo_cuenta"
                                    render={({ field }) => (
                                        <FormItem>
                                            <FormLabel>Tipo de Cuenta de Banco</FormLabel>
                                            <FormControl>
                                                <Input placeholder="Ingrese el tipo de cuenta de banco" {...field} />
                                            </FormControl>
                                            <FormMessage />
                                        </FormItem>
                                    )}
                                />

                                <div className="flex justify-between">
                                    <Button variant="outline" type="button" asChild>
                                        <a href="/account_types_banks">Cancelar</a>
                                    </Button>

                                    <Button type="submit">Guardar</Button>
                                </div>

                            </form>
                        </Form>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    )
}
