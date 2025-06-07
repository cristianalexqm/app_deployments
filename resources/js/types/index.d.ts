import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

import { LucideIcon } from "lucide-react"

export interface NavItem {
    title: string
    href: string
    icon?: LucideIcon | null
    isActive?: boolean
    items?: NavItem[]
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    [key: string]: unknown;
    flash?: {
        success?: string
        error?: string
        [key: string]: string | undefined
    }
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export type Payment = {
    id: string
    amount: number
    state: "pending" | "processing" | "success" | "failed"
    email: string
}

export type Currencie = {
    id: string
    cod: string
    moneda: string
    naturaleza: string
    estado: boolean
}

export type CardType = {
    id: string
    cod: string
    emisor: string
    estado: boolean
}

export type MobileOperator = {
    id: string
    cod: string
    operador: string
    estado: boolean
}

export type AccountClasses = {
    id: string
    cod: string
    tipo_clase_cuenta: string
    estado: boolean
}

export type AccountTypeBanks = {
    id: string
    cod: string
    tipo_cuenta: string
    estado: boolean
}

export type BankType = {
    id: string
    cod: string
    tipo_banco: string
    tipo_recurso: string
    tipos_cuentas_bancos_id: number
    tipo_cuenta_banco: {
        id: number
        tipo_cuenta: string
    }
    estado: boolean
}

export type DocumentType = {
    id: string
    code: string
    nombre: string
}

export type QuoteProvider = {
    id: string
    nombre: string
    descripcion: string
}

export type TipoRedCripto = {
    id: string
    cod: string
    red: string
    estado: boolean
}

export type WorkerType = {
    id: string
    code: string
    nombre: string
}

export type AfpType = {
    id: string
    code: string
    nombre: string
}

export type AfpCommissionType = {
    id: string
    code: string
    nombre: string
}