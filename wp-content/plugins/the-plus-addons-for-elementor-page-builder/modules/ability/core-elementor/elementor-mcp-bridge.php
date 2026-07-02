<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sanitize JSON schemas so MCP clients do not choke on empty enum values.
 */
function tpae_elementor_mcp_sanitize_schema(array $schema): array
{
    if (isset($schema['enum']) && is_array($schema['enum'])) {
        $schema['enum'] = array_values(
            array_filter(
                $schema['enum'],
                static function ($value) {
                    return '' !== $value;
                }
            )
        );

        if ($schema['enum'] === []) {
            unset($schema['enum']);
        }
    }

    if (isset($schema['properties']) && is_array($schema['properties'])) {
        if ($schema['properties'] === []) {
            $schema['properties'] = new stdClass();
        } else {
            foreach ($schema['properties'] as $key => $prop) {
                if (is_array($prop)) {
                    $schema['properties'][$key] = tpae_elementor_mcp_sanitize_schema($prop);
                }
            }
        }
    }

    if (isset($schema['items']) && is_array($schema['items'])) {
        $schema['items'] = tpae_elementor_mcp_sanitize_schema($schema['items']);
    }

    foreach (['allOf', 'oneOf', 'anyOf'] as $keyword) {
        if (isset($schema[$keyword]) && is_array($schema[$keyword])) {
            foreach ($schema[$keyword] as $index => $sub_schema) {
                if (is_array($sub_schema)) {
                    $schema[$keyword][$index] = tpae_elementor_mcp_sanitize_schema($sub_schema);
                }
            }
        }
    }

    return $schema;
}

/**
 * Map ported elementor-mcp ability names into the Sprout namespace.
 *
 * Existing Sprout abilities keep their current names. Imported collisions are
 * prefixed with `elementor-` so both versions can coexist.
 */
function tpae_elementor_mcp_map_ability_name(string $name): string
{
    if (!str_starts_with($name, 'elementor-mcp/')) {
        return $name;
    }

    $slug = substr($name, strlen('elementor-mcp/'));
    $collisions = [
        'create-page',
        'add-container',
        'update-container',
        'update-element',
        'batch-update',
        'reorder-elements',
        'move-element',
        'remove-element',
        'duplicate-element',
        'get-page-structure',
    ];

    if (in_array($slug, $collisions, true)) {
        return 'tpae/elementor-' . $slug;
    }

    return 'tpae/' . $slug;
}

/**
 * Register a ported Elementor MCP ability under the Sprout namespace.
 */
function tpae_elementor_mcp_register_ability(string $name, array $args)
{
    if (isset($args['input_schema']) && is_array($args['input_schema'])) {
        $args['input_schema'] = tpae_elementor_mcp_sanitize_schema($args['input_schema']);
    }

    if (isset($args['output_schema']) && is_array($args['output_schema'])) {
        $args['output_schema'] = tpae_elementor_mcp_sanitize_schema($args['output_schema']);
    }

    $args['category'] = 'tpae';

    $meta = isset($args['meta']) && is_array($args['meta']) ? $args['meta'] : [];
    $meta['show_in_rest'] = true;
    $meta['mcp'] = array_merge(
        [
            'public' => true,
            'type' => 'tool',
        ],
        isset($meta['mcp']) && is_array($meta['mcp']) ? $meta['mcp'] : []
    );
    $args['meta'] = $meta;

    return wp_register_ability(tpae_elementor_mcp_map_ability_name($name), $args);
}

/**
 * SSRF guard — rejects URLs that resolve to loopback / private / link-local IPs,
 * blocks non-http(s) schemes, and returns a WP_Error if unsafe.
 *
 * @param string $url
 * @return true|\WP_Error
 */
function tpae_elementor_mcp_is_safe_remote_url($url)
{
    if (!is_string($url) || $url === '') {
        return new \WP_Error('invalid_url', __('Empty URL.', 'tpebl'));
    }

    $parts = wp_parse_url($url);
    if (empty($parts['scheme']) || empty($parts['host'])) {
        return new \WP_Error('invalid_url', __('Malformed URL.', 'tpebl'));
    }

    $scheme = strtolower($parts['scheme']);
    if (!in_array($scheme, array('http', 'https'), true)) {
        return new \WP_Error('invalid_scheme', __('Only http/https URLs are allowed.', 'tpebl'));
    }

    $host = strtolower($parts['host']);

    // Block obvious local hostnames.
    $blocked_hosts = array('localhost', 'localhost.localdomain', '127.0.0.1', '0.0.0.0', '::1');
    if (in_array($host, $blocked_hosts, true)) {
        return new \WP_Error('blocked_host', __('Blocked host.', 'tpebl'));
    }

    // Resolve host to IP(s) and block private ranges.
    $ips = array();
    if (filter_var($host, FILTER_VALIDATE_IP)) {
        $ips[] = $host;
    } else {
        $records = @dns_get_record($host, DNS_A + DNS_AAAA);
        if (is_array($records)) {
            foreach ($records as $r) {
                if (!empty($r['ip'])) {
                    $ips[] = $r['ip'];
                } elseif (!empty($r['ipv6'])) {
                    $ips[] = $r['ipv6'];
                }
            }
        }
        if (empty($ips)) {
            $resolved = gethostbyname($host);
            if ($resolved && $resolved !== $host) {
                $ips[] = $resolved;
            }
        }
    }

    foreach ($ips as $ip) {
        if (!filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        )) {
            return new \WP_Error('blocked_ip', __('URL resolves to a private or reserved IP range.', 'tpebl'));
        }
    }

    return true;
}

require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/class-id-generator.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/class-elementor-data.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/class-element-factory.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/class-openverse-client.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/schemas/class-control-mapper.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/schemas/class-schema-generator.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/validators/class-element-validator.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/validators/class-settings-validator.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/abilities/class-query-abilities.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/abilities/class-page-abilities.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/abilities/class-layout-abilities.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/abilities/class-template-abilities.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/abilities/class-global-abilities.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/abilities/class-composite-abilities.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/abilities/class-stock-image-abilities.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/abilities/class-svg-icon-abilities.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/abilities/class-custom-code-abilities.php';
require_once L_THEPLUS_PATH . 'modules/ability/core-elementor/mcp-tools/abilities/class-ability-registrar.php';

$tpae_elementor_mcp_data = new Tpae_Elementor_MCP_Data();
$tpae_elementor_mcp_factory = new Tpae_Elementor_MCP_Element_Factory();
$tpae_elementor_mcp_schema_generator = new Tpae_Elementor_MCP_Schema_Generator();
$tpae_elementor_mcp_validator = new Tpae_Elementor_MCP_Settings_Validator($tpae_elementor_mcp_schema_generator);
$tpae_elementor_mcp_registrar = new Tpae_Elementor_MCP_Ability_Registrar(
    $tpae_elementor_mcp_data,
    $tpae_elementor_mcp_factory,
    $tpae_elementor_mcp_schema_generator,
    $tpae_elementor_mcp_validator
);
$tpae_elementor_mcp_registrar->register_all();
