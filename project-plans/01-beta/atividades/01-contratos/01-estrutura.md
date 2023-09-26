* Se basear em https://contendasdosincora.ba.gov.br/contratos/

```php
// Exemplo atual
/*
Nº 001/2023 | SUPPORT CONSULTORIA E ASSESSORIA CONTABIL LTDA EPP

Nº 001/2023  | CONTRATADA: SUPPORT CONSULTORIA E ASSESSORIA CONTABIL LTDA EPP

Vigência: 04/01/2023 a 31/12/2023 | Valor: R$ 198.000,00 | Ato: Inexigibilidade Nº 001/2023

Extrato do Contrato

Objeto: Prestação de serviços especializados de consultoria e assessoria contábil.
*/
```

Plano para a execução
```php
class Year {
    const DATE_FORMAT = 'Y';
}

class Month {
    const DATE_FORMAT = 'm';
}

class Day {
    const DATE_FORMAT = 'd';
}

class Date {
    const DATE_FORMAT = 'Y-m-d';
}

class DateTime {
    const DATE_FORMAT = 'Y-m-d H:i:s';
}

class City {
    public int $id; // [INDEX]
    public string $state_code; // [INDEX]
    public string $state_name; // [INDEX]
    public string $state_local_name; // [INDEX]
    public string $country_iso_code; // [INDEX] // BR|PT|US
}

class PlaceType {
    public string $type; // rua, avenida, travessa, n_a etc
}

class Address {
    public City $city_id; // [INDEX]
    public PlaceType $place_type; // [INDEX]
    public string $part_1; // Os campos podem ser usados para mapeamentos como rua, número bairro etc
    public ?string $part_2;
    public ?string $part_4;
    public ?string $part_5;
}

class DocType {
    const cnpj = 'cnpj';
    const cpf = 'cpf';
    const passport = 'passport';
    const other = 'other';
    const no_one = 'no_one';
    // ...
}

class Contratado {
    public string $name; // [INDEX]
    public ?string $doc_type_enum; // [INDEX]
    public ?string $legal_name; // Razão social:
    public ?string $trading_name; // Nome fantasia:
    public ?string $doc; // [INDEX] limpar caracteres especiais. Aceitar apenas [a-zA-Z0-9]
    public ?string $doc_2_type_enum; // [INDEX]
    public ?string $doc_2; // [INDEX] útil para dados como IE, Razão social etc
    public ?Address $address_id;
}

class AtoTipo {
    const pregao_eletronico = 'pregao_eletronico';
    // ...
}

class File {
    public ?string $tenant_id; // Aqui uso no geral ou separo por tenant??? Acho que vai ser por tenant
    public string $disk_name;
    public string $fale_path;
    public ?string $visibility;
}

class RegistroDePreco {
    public ?int $ata; // [INDEX]
    public ?int $ano; // [INDEX]
    public ?File $extrato_do_contrato; // [INDEX]
}

class AtoDeContrato {
    public ?AtoTipo $tipo; // [INDEX]
    public ?string $numero; // [INDEX]
    public ?int $ano; // [INDEX]
}

class Contrato {
    public Contratado $contratado_id; // [INDEX]
    public ?string $numero; // [INDEX]
    public ?string $ano_relacionado; // [INDEX]
    public ?string $vigencia_inicio; // [INDEX]
    public ?string $vigencia_fim; // [INDEX]
    public ?string $valor; // [INDEX]
    public ?AtoDeContrato $ato_de_contrato; // [INDEX]
    public ?RegistroDePreco $registro_de_preco; // [INDEX] // pode não conter esse 'registro'. Exemplo de existencia:  Nº 047/2023 | WAGNER AUTO PEÇAS LTDA - ME -> https://contendasdosincora.ba.gov.br/contratos/
    public ?string $objeto; // (descrição)
}

```
