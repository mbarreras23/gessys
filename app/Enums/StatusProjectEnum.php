<?php

namespace App\Enums;

use ArchTech\Enums\{InvokableCases, Metadata, Values};
use App\Enums\MetaProperties\{ClassName, Description};
use ArchTech\Enums\Meta\Meta;

#[Meta(Description::class, ClassName::class)]
enum StatusProjectEnum: string
{
    use InvokableCases, Values, Metadata;

    #[Description("En espera")] #[ClassName("badge text-bg-secondary")]
    case WAITING = "waiting";

    #[Description("Activo")] #[ClassName("badge text-bg-success")]
    case ACIVE = "active";

    #[Description("Finalizado")] #[ClassName("badge text-bg-ligth")]
    case FINALIZED = "finalized";

    #[Description("Supendido")] #[ClassName("badge text-bg-danger")]
    case SUSPENDED = "suspended";
}
