<?php

return [
    'created_at' => 'Criado em',
    'created_from' => 'Criado a partir de',
    'created_until' => 'Criado até',
    'updated_at' => 'Atualizado em',
    'from' => 'De',
    'until' => 'Até',
    'from_date' => 'A partir da data',
    'until_date' => 'Até a data',
    'tenant' => [
        'impersonate' => 'Personificar',
        'impersonate_as' => 'Personificar como :tenant',
        'act_as' => 'Agir como :tenant',
        'impersonated' => 'Personificado',
        'impersonated_as' => 'Personificado como :tenant',
        'acting_as' => 'Atuando como :tenant',
        'remove_impersonated' => 'Encerrar personificação',
        'tenant_info' => 'Ver detalhes',
    ],
    'users' => [
        'filters' => [
            'active' => 'Usuários ativos',
            'inactive' => 'Usuários inativo',
            'validated_email' => 'Com e-mail validado',
            'not_validated_email' => 'Sem e-mail validado',
        ]
    ],
    'pages' => [
        'settings' => [
            'title' => 'Configurações',
        ],
        'account_settings' => [
            'title' => 'Perfil',
        ],
    ],
    'orcamento' => [
        'tipo' => 'Tipo',
        'edit' => 'Editar orçamento',
        'vigencia' => 'Vigência',
        'ano_vigencia_inicio' => 'Vigência inicio',
        'ano_vigencia_fim' => 'Vigência fim',
        'active' => 'Ativo',
        'filter' => [
            'ano_vigencia_inicio' => 'Vigência inicio',
            'ano_vigencia_fim' => 'Vigência fim',
            'tipo_ldo' => 'Tipo LDO',
            'tipo_loa' => 'Tipo LOA',
            'tipo_ppa' => 'Tipo PPA',
        ],
    ],
    'orcamento_item' => [
        'lei_tipo' => 'Tipo de lei',
        'created_at' => 'Data de cadastro',
        'lei_numero' => 'Numero da lei',
        'lei_data' => 'Data da lei',
        'date_format' => 'd/m/Y',
        'datetime_format' => 'd/m/Y H:i',
        'content' => 'Conteúdo',
        'list_title' => 'Itens do orçamento',
        'detail_title' => 'Item de orçamento',
        'edit_title' => 'Editar item de orçamento',
        'aditional_data' => 'Dados adicionais',
        'aditional_data_help' => 'Pode-se usar para criar itens com chave/valor. Por exemplo: Cidade: Curitiba ou UF: RO',
        'aditional_data_key_placeholder' => 'Chave. Ex: Cidade',
        'aditional_data_key' => 'Coluna esquerda',
        'aditional_data_value' => 'Coluna direita',
        'aditional_data_value_placeholder' => 'Valor. Ex: Curitiba',
        'warning_alert_title' => 'Há campos que requerem sua atenção!',
        'warning_alert_message' => '',
        'create_action_label' => 'Novo item',
    ],
];
