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
import type { AccountTypeBanks, BankType, BreadcrumbItem } from "@/types"

const breadcrumbs: BreadcrumbItem[] = [
    { title: "Catálogo", href: "#" },
    { title: "Tipos Bancos", href: "/bank_types" },
    { title: "Editar tipo banco", href: "" },
]

const schema = z.object({
    cod: z.string().min(1, "Código requerido").max(10),
    tipo_banco: z.string().min(1, "Nombre banco requerido").max(50),
    tipo_recurso: z.string().min(1, "Tipo recurso requerido"),
    tipos_cuentas_bancos_id: z.coerce.number().min(1, "Tipo de cuenta requerido"),
    estado: z.boolean().optional(),
})

type FormValues = z.infer<typeof schema>

export default function EditTipoBancoPage({ tipo_banco, tipos_recurso, tipos_cuentas }: { tipo_banco: BankType, tipos_recurso: string[], tipos_cuentas: AccountTypeBanks[] }) {
    const form = useForm<FormValues>({
        resolver: zodResolver(schema),
        defaultValues: {
            cod: tipo_banco.cod,
            tipo_banco: tipo_banco.tipo_banco,
            tipo_recurso: tipo_banco.tipo_recurso,
            tipos_cuentas_bancos_id: tipo_banco.tipos_cuentas_bancos_id,
            estado: tipo_banco.estado,
        },
    })

    const onSubmit = (data: FormValues) => {
        router.put(`/bank_types/${tipo_banco.id}`, data)
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar Tipo Banco" />
            <div className="container mx-auto py-10 max-w-xl">
                <Card>
                    <CardHeader>
                        <CardTitle className="text-center">Editar tipo banco</CardTitle>
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
                                    name="tipo_banco"
                                    render={({ field }) => (
                                        <FormItem>
                                            <FormLabel>Nombre Tipo Banco</FormLabel>
                                            <FormControl>
                                                <Input placeholder="Ingrese el nombre del tipo banco" {...field} />
                                            </FormControl>
                                            <FormMessage />
                                        </FormItem>
                                    )}
                                />

                                <FormField
                                    control={form.control}
                                    name="tipo_recurso"
                                    render={({ field }) => (
                                        <FormItem>
                                            <FormLabel>Tipo de Recurso</FormLabel>
                                            <FormControl>
                                                <Select
                                                    value={field.value}
                                                    onValueChange={field.onChange}
                                                >
                                                    <SelectTrigger>
                                                        <SelectValue placeholder="Selecciona tipo de recurso" />
                                                    </SelectTrigger>
                                                    <SelectContent>
                                                        {tipos_recurso.map((recurso) => (
                                                            <SelectItem key={recurso} value={recurso}>
                                                                {recurso.charAt(0).toUpperCase() + recurso.slice(1)}
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
                                    name="tipos_cuentas_bancos_id"
                                    render={({ field }) => (
                                        <FormItem>
                                            <FormLabel>Tipo de Cuenta Banco</FormLabel>
                                            <FormControl>
                                                <Select
                                                    value={String(field.value)}
                                                    onValueChange={(value) => field.onChange(Number(value))}
                                                >
                                                    <SelectTrigger>
                                                        <SelectValue placeholder="Selecciona tipo de cuenta" />
                                                    </SelectTrigger>
                                                    <SelectContent>
                                                        {tipos_cuentas.map((cuenta) => (
                                                            <SelectItem key={cuenta.id} value={String(cuenta.id)}>
                                                                {cuenta.tipo_cuenta}
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
                                        <a href="/bank_types">Cancelar</a>
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
