import * as React from "react"
import { Slot } from "@radix-ui/react-slot"
import { cva, type VariantProps } from "class-variance-authority"

import { cn } from "@/lib/utils"

const badgeVariants = cva(
  "inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-auto",
  {
    variants: {
      variant: {
        default:
          "border-transparent bg-primary text-primary-foreground [a&]:hover:bg-primary/90",
        secondary:
          "border-transparent bg-secondary text-secondary-foreground [a&]:hover:bg-secondary/90",
        destructive:
          "border-transparent bg-destructive text-white [a&]:hover:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40",
        outline:
          "text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground",

        violetaPrimario: "bg-violet-600 text-white shadow-xs hover:bg-violet-700 focus-visible:ring-violet-600/20 dark:focus-visible:ring-violet-600/40 dark:bg-violet-700",

        violetaSecundario: "bg-violet-100 text-violet-800 hover:bg-violet-200 focus-visible:ring-violet-300/30 dark:bg-violet-200/10 dark:text-violet-300 dark:hover:bg-violet-200/20",

        violetaTerciario: "bg-violet-50 text-violet-700 hover:bg-violet-100 dark:bg-violet-50/5 dark:text-violet-200",

        violetaLigero: "bg-violet-200 hover:bg-violet-300 text-current dark:bg-violet-200/10 dark:hover:bg-violet-200/20",

        violetaFuerte: "bg-violet-700 text-white hover:bg-violet-800 dark:bg-violet-800",

        violetaOscuro: "bg-violet-900 text-white hover:bg-violet-800 dark:hover:bg-violet-700",

        violetaGhost: "hover:bg-violet-500/10 focus-visible:ring-violet-500/20 dark:hover:bg-violet-500/20",

        violetaSoftBadge: "bg-violet-500/20", // no text color = hereda

        violetaStrongBadge: "bg-violet-600 text-white",

        violetaAdaptiveBadge: "bg-violet-100 text-violet-800 dark:bg-violet-300/10 dark:text-violet-300",
      },
    },
    defaultVariants: {
      variant: "default",
    },
  }
)

function Badge({
  className,
  variant,
  asChild = false,
  ...props
}: React.ComponentProps<"span"> &
  VariantProps<typeof badgeVariants> & { asChild?: boolean }) {
  const Comp = asChild ? Slot : "span"

  return (
    <Comp
      data-slot="badge"
      className={cn(badgeVariants({ variant }), className)}
      {...props}
    />
  )
}

export { Badge, badgeVariants }
