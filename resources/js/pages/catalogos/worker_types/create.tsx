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
    { title: "Tipo Trabajador", href: "/worker_types" },
    { title: "Crear tipo de trabajador", href: "" },
]

const schema = z.object({
    code: z.string().min(1, "Código requerido").max(10),
    nombre: z.string().min(1, "Nombre del tipo de trabajador requerido").max(100),
})

type FormValues = z.infer<typeof schema>

export default function CreateWorkerTypePage() {
    const form = useForm<FormValues>({
        resolver: zodResolver(schema),
        defaultValues: {
            code: "",
            nombre: "",
        },
    })

    const onSubmit = (data: FormValues) => {
        router.post("/worker_types", data)
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Tipo Trabajador" />
            <div className="container mx-auto py-10 max-w-xl">
                <Card>
                    <CardHeader>
                        <CardTitle className="text-center">Registrar nuevo tipo de trabajador</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Form {...form}>
                            <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-4">
                                <FormField
                                    control={form.control}
                                    name="code"
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
                                    name="nombre"
                                    render={({ field }) => (
                                        <FormItem>
                                            <FormLabel>Nombre</FormLabel>
                                            <FormControl>
                                                <Input placeholder="Ingrese el nombre del tipo de trabajador" {...field} />
                                            </FormControl>
                                            <FormMessage />
                                        </FormItem>
                                    )}
                                />

                                <div className="flex justify-between">
                                    <Button variant="outline" type="button" asChild>
                                        <a href="/worker_types">Cancelar</a>
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
