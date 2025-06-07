import AppLayout from "@/layouts/app-layout"
import { Head, router } from "@inertiajs/react"
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
import type { BreadcrumbItem } from "@/types"

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Catálogo", href: "#" },
    { title: "Monedas", href: "/currencies" },
    { title: "Crear moneda", href: "" },
]

const schema = z.object({
    cod: z.string().min(1, "Código requerido").max(10),
    moneda: z.string().min(1, "Nombre requerido").max(50),
    naturaleza: z.string().min(1, "Naturaleza requerida"),
})

type FormValues = z.infer<typeof schema>

export default function CreateMonedaPage({ naturalezas }: { naturalezas: string[] }) {
    const form = useForm<FormValues>({
        resolver: zodResolver(schema),
        defaultValues: {
            cod: "",
            moneda: "",
            naturaleza: "",
        },
    })

    const onSubmit = (data: FormValues) => {
        router.post("/currencies", data)
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Moneda" />
            <div className="container mx-auto py-10 max-w-xl">
                <Card>
                    <CardHeader>
                        <CardTitle className="text-center">Registrar nueva moneda</CardTitle>
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
                                    name="moneda"
                                    render={({ field }) => (
                                        <FormItem>
                                            <FormLabel>Moneda</FormLabel>
                                            <FormControl>
                                                <Input placeholder="Ingrese el nombre" {...field} />
                                            </FormControl>
                                            <FormMessage />
                                        </FormItem>
                                    )}
                                />

                                <FormField
                                    control={form.control}
                                    name="naturaleza"
                                    render={({ field }) => (
                                        <FormItem>
                                            <FormLabel>Naturaleza</FormLabel>
                                            <FormControl>
                                                <Select onValueChange={field.onChange} value={field.value}>
                                                    <SelectTrigger>
                                                        <SelectValue placeholder="Selecciona naturaleza" />
                                                    </SelectTrigger>
                                                    <SelectContent>
                                                        {naturalezas.map((item) => (
                                                            <SelectItem key={item} value={item}>
                                                                {item.charAt(0).toUpperCase() + item.slice(1)}
                                                            </SelectItem>
                                                        ))}
                                                    </SelectContent>
                                                </Select>
                                            </FormControl>
                                            <FormMessage />
                                        </FormItem>
                                    )}
                                />

                                <div className="flex justify-between">
                                    <Button variant="outline" type="button" asChild>
                                        <a href="/currencies">Cancelar</a>
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
