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
import type { AfpCommissionType, BreadcrumbItem } from "@/types"

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Catálogo", href: "#" },
    { title: "Tipo Comisión AFP", href: "/afp_commission_types" },
    { title: "Editar tipo de comisión AFP", href: "" },
]

const schema = z.object({
    code: z.string().min(1, "Código requerido").max(20),
    nombre: z.string().min(1, "Nombre de tipo de comisión AFP requerido").max(50),
})

type FormValues = z.infer<typeof schema>

export default function EditAfpCommissionTypePage({ afpCommissionType }: { afpCommissionType: AfpCommissionType }) {
    const form = useForm<FormValues>({
        resolver: zodResolver(schema),
        defaultValues: {
            code: afpCommissionType.code,
            nombre: afpCommissionType.nombre,
        },
    })

    const onSubmit = (data: FormValues) => {
        router.put(`/afp_commission_types/${afpCommissionType.id}`, data)
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar Tipo Comisión AFP" />
            <div className="container mx-auto py-10 max-w-xl">
                <Card>
                    <CardHeader>
                        <CardTitle className="text-center">Editar tipo comisión AFP</CardTitle>
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
                                                <Input placeholder="Ingrese el tipo de AFP" {...field} />
                                            </FormControl>
                                            <FormMessage />
                                        </FormItem>
                                    )}
                                />

                                <div className="flex justify-between">
                                    <Button variant="outline" type="button" asChild>
                                        <a href="/afp_commission_types">Cancelar</a>
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