import { NavFooter } from '@/components/nav-footer';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/react';
import { BadgeCent, BadgePercent, BookOpen, CirclePercent, CreditCard, DollarSign, Folder, Hammer, HandCoins, IdCard, Landmark, PackageOpen, PiggyBank, Smartphone } from 'lucide-react';
import AppLogo from './app-logo';
import { NavMain } from './nav-main';

const navItems: NavItem[] = [
    {
        title: "Dashboard",
        href: "/dashboard",
        icon: BookOpen,
    },
    {
        title: "Catalogo",
        href: "/catalogo",
        icon: Folder,
        items: [
            { title: "Tipo de Tarjetas", href: "/card_types", icon: CreditCard },
            { title: "Monedas", href: "/currencies", icon: DollarSign },
            { title: "Operadores Moviles", href: "/mobile_operators", icon: Smartphone },
            { title: "Clases Cuentas", href: "/account_classes", icon: HandCoins },
            { title: "Cuentas Bancos", href: "/account_types_banks", icon: PiggyBank },
            { title: "Tipos Bancos", href: "/bank_types", icon: Landmark },
            { title: "Tipos Documentos", href: "/document_types", icon: IdCard },
            { title: "Cuota Porveedor", href: "/quote_providers", icon: PackageOpen },
            { title: "Tipo Red Cripto", href: "/tipo_red_cripto", icon: BadgeCent },
            { title: "Tipo Trabajador", href: "/worker_types", icon: Hammer },
            { title: "Tipo AFP", href: "/afp_types", icon: BadgePercent },
            { title: "Tipo Comisión AFP", href: "/afp_commission_types", icon: CirclePercent },
        ],
    },
    {
        title: "Finanzas",
        href: "/",
        icon: Folder,
        items: [
            { title: "Datos Personales Bancarios", href: "/", icon: CreditCard },
        ],
    },
    {
        title: "Directorio Empresas / Personas",
        href: "/",
        icon: Folder,
        items: [
            { title: "Registro Persona/Empresa", href: "/", icon: CreditCard },
            {
                title: "Directorio Tipo", href: "/", icon: DollarSign, items: [
                    {
                        title: "Ver Empleado", href: "/", icon: CreditCard, items: [
                            { title: "Ver Proveedor", href: "/", icon: CreditCard },
                        ]
                    },
                    { title: "Ver Proveedor", href: "/", icon: CreditCard },
                    { title: "Ver Cliente", href: "/", icon: CreditCard },
                    { title: "Ver Empresa Propia", href: "/", icon: CreditCard },
                    { title: "Ver Accionista", href: "/", icon: CreditCard },
                ]
            },
        ],
    },
    {
        title: "Casas de Apuestas",
        href: "/",
        icon: Folder,
        items: [
            { title: "Tipo de Tarjetas", href: "/card_types", icon: CreditCard },
        ],
    },
]

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/dashboard" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={navItems} />
            </SidebarContent>

            <SidebarFooter>
                {<NavFooter items={footerNavItems} className="mt-auto" />}
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
