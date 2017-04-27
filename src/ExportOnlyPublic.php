<?php

namespace Ornament\Json;

use Ornament\Core\ModelCheck;
use StdClass;

trait ExportOnlyPublic
{
    use ModelCheck {
        ModelCheck::check as __ornamentExportOnlyPublicCheck;
    }

    /**
     * Returns a StdClass model representation suitable for Json serialization.
     * This trait only exports public properties.
     *
     * @return StdClass
     * @throws DomainException if called on a non-Ornament model
     */
    public function jsonSerialize() : StdClass
    {
        $this->__exportOnlyPublicCheck();
        $annotations = $this->__ornamentalize();
        $export = new StdClass;
        foreach ($annotations['properties'] as $name => $anns) {
            if (!$anns['readOnly']) {
                $export->$name = $this->$name;
            }
        }
        return $export;
    }
}

