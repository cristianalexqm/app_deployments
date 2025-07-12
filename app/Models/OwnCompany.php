<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnCompany extends Model
{
    use HasFactory;

    protected $table = 'empresa_propia';
    protected $fillable = [
        'representante_legal',
        'tipo_documento_id',
        'documento_gerente',
        'partida_registral',
        'oficina_registral',
        'fecha_constitucion',
        'estado_empresa',
        'fecha_cierre',
        'nro_acciones_total',
        'correo_empresa',
        'password',
        'tipo_control',
        'dato_extra_tipo_entidad_id'
    ];

    // Relación con TipoEntidad (Cada empresa propia pertenece a un tipo de entidad)
    public function tipoEntidad()
    {
        return $this->belongsTo(EntityType::class, 'dato_extra_tipo_entidad_id');
    }

    // Relación con TipoDocumento (Documento legal del representante de la empresa)
    public function tipoDocumento()
    {
        return $this->belongsTo(DocumentType::class, 'tipo_documento_id');
    }

    // Relación con Accionistas de la empresa propia
    public function accionistas()
    {
        return $this->hasMany(ShareholderOwnCompany::class, 'empresa_propia_id');
    }

    public function accountingAccounts()
    {
        return $this->hasMany(AccountingAccount::class, 'own_company_id');
    }

    // public function companyAssociates()
    // {
    //     return $this->hasMany(CompanyAssociateAccounting::class, 'own_company_id');
    // }

    public function associateCompanies()
    {
        return $this->hasMany(AssociateCompany::class, 'own_company_id');
    }

    public function associateTypeAssociateCompanies()
    {
        return $this->hasMany(AssociateTypeAssociateCompany::class, 'own_company_id');
    }
}
