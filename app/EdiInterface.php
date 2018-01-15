<?php

namespace App;

class EdiInterface extends UuidModel
{
    protected $fillable = [
        'agreement_uuid',
        'file_size',
        'file_name',
        'file_type',
        'file_at',
        'interface_partner',
        'interface_channel',
        'interface_version',
        'interface_source',
        'interface_destination',
        'interface_control_number',
        'interface_at'
    ];
}
