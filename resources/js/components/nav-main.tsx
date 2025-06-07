/* import { Link, usePage } from "@inertiajs/react"
import { ChevronRight } from "lucide-react"
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from "@/components/ui/collapsible"
import {
    SidebarGroup,
    SidebarMenu,
    SidebarMenuItem,
    SidebarMenuButton,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from "@/components/ui/sidebar"

import { type NavItem } from '@/types/index';

export function NavMain({ items = [] }: { items: NavItem[] }) {
    const page = usePage()
    const currentUrl = page.url

    return (
        <SidebarGroup>
            <SidebarMenu>
                {items.map((item) => {
                    const isSubitemActive = item.items?.some((sub) => currentUrl === sub.href)
                    const isItemActive = currentUrl === item.href || isSubitemActive
                    const openByDefault = isItemActive

                    return item.items && item.items.length > 0 ? (
                        <Collapsible
                            key={item.title}
                            asChild
                            defaultOpen={openByDefault}
                            className="group/collapsible"
                        >
                            <SidebarMenuItem>
                                <CollapsibleTrigger asChild>
                                    <SidebarMenuButton
                                        tooltip={item.title}
                                    >
                                        {item.icon && <item.icon />}
                                        <span>{item.title}</span>
                                        <ChevronRight className="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                                    </SidebarMenuButton>
                                </CollapsibleTrigger>
                                <CollapsibleContent>
                                    <SidebarMenuSub>
                                        {item.items.map((subItem) => {
                                            const isSubActive = currentUrl === subItem.href
                                            return (
                                                
                                                <SidebarMenuSubItem key={subItem.title}>
                                                <SidebarMenuSubButton asChild isActive={isSubActive}>
                                                  <a href={subItem.href} className="flex items-center gap-2">
                                                    {subItem.icon && <subItem.icon className="w-4 h-4" />}
                                                    <span>{subItem.title}</span>
                                                  </a>
                                                </SidebarMenuSubButton>
                                              </SidebarMenuSubItem>
                                            )
                                        })}
                                    </SidebarMenuSub>
                                </CollapsibleContent>
                            </SidebarMenuItem>
                        </Collapsible>
                    ) : (
                        <SidebarMenuItem key={item.title}>
                            <SidebarMenuButton
                                asChild
                                isActive={currentUrl === item.href}
                                tooltip={{ children: item.title }}
                            >
                                <a href={item.href}>
                                    {item.icon && <item.icon />}
                                    <span>{item.title}</span>
                                </a>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    )
                })}
            </SidebarMenu>
        </SidebarGroup>
    )
}
 */

import { Link, usePage } from "@inertiajs/react"
import { ChevronRight } from "lucide-react"
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from "@/components/ui/collapsible"
import {
    SidebarGroup,
    SidebarMenu,
    SidebarMenuItem,
    SidebarMenuButton,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from "@/components/ui/sidebar"
import { type NavItem } from "@/types"

export function NavMain({ items = [] }: { items: NavItem[] }) {
    return (
        <SidebarGroup>
            <SidebarMenu>
                {items.map((item) => (
                    <RenderNavItem key={item.title} {...item} />
                ))}
            </SidebarMenu>
        </SidebarGroup>
    )
}

function RenderNavItem(item: NavItem) {
    const { url: currentUrl } = usePage()

    const hasChildren = item.items && item.items.length > 0
    const isActive =
        currentUrl === item.href || item.items?.some((i) => currentUrl === i.href)

    if (hasChildren) {
        return (
            <Collapsible key={item.title} asChild defaultOpen={isActive}>
                <SidebarMenuItem>
                    <CollapsibleTrigger asChild>
                        <SidebarMenuButton tooltip={item.title}>
                            {item.icon && <item.icon />}
                            <span>{item.title}</span>
                            <ChevronRight className="ml-auto transition-transform group-data-[state=open]:rotate-90" />
                        </SidebarMenuButton>
                    </CollapsibleTrigger>
                    <CollapsibleContent>
                        <SidebarMenuSub>
                            {item.items?.map((subItem) => (
                                <SidebarMenuSubItem key={subItem.title}>
                                    <RenderNavItem {...subItem} />
                                </SidebarMenuSubItem>
                            ))}
                        </SidebarMenuSub>
                    </CollapsibleContent>
                </SidebarMenuItem>
            </Collapsible>
        )
    }

    return (
        <SidebarMenuItem key={item.title}>
            <SidebarMenuButton
                asChild
                isActive={currentUrl === item.href}
                tooltip={{ children: item.title }}
            >
                <Link href={item.href} className="flex items-center gap-2">
                    {item.icon && <item.icon className="w-4 h-4" />}
                    <span>{item.title}</span>
                </Link>
            </SidebarMenuButton>
        </SidebarMenuItem>
    )
}
