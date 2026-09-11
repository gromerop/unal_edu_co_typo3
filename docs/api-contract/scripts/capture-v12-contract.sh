#!/usr/bin/env bash

set -euo pipefail

base_url="${1:-https://unal-typo3-ddev.ddev.site}"
output_dir="${2:-docs/api-contract/fixtures/typo3-v12}"
existing_uid="${3:-537}"
missing_uid="${4:-4941}"
curl_bin="${CURL_BIN:-/usr/bin/curl}"

mkdir -p "$output_dir"

capture() {
    local name="$1"
    local method="$2"
    local path="$3"
    local request_body="${4:-}"
    local raw_headers
    local raw_body
    local body_extension
    local http_code
    local content_type

    if [[ -n "${CAPTURE_ONLY:-}" && "$name" != "$CAPTURE_ONLY" ]]; then
        return 0
    fi

    raw_headers="$(mktemp)"
    raw_body="$(mktemp)"

    if [[ -n "$request_body" ]]; then
        read -r http_code content_type < <(
            "$curl_bin" -kLsS \
                --retry 2 \
                --retry-all-errors \
                --connect-timeout 10 \
                -X "$method" \
                -H 'Content-Type: application/json' \
                -d "$request_body" \
                -D "$raw_headers" \
                -o "$raw_body" \
                -w '%{http_code} %{content_type}\n' \
                "$base_url$path"
        )
    else
        read -r http_code content_type < <(
            "$curl_bin" -kLsS \
                --retry 2 \
                --retry-all-errors \
                --connect-timeout 10 \
                -X "$method" \
                -D "$raw_headers" \
                -o "$raw_body" \
                -w '%{http_code} %{content_type}\n' \
                "$base_url$path"
        )
    fi

    if [[ "$content_type" == text/html* ]]; then
        body_extension="html"
    else
        body_extension="json"
    fi
    rm -f "$output_dir/$name.json" "$output_dir/$name.html"
    mv "$raw_body" "$output_dir/$name.$body_extension"

    /usr/bin/tr -d '\r' < "$raw_headers" \
        | /usr/bin/grep -Ei \
            '^(HTTP/|Content-Type:|Cache-Control:|Access-Control-Allow-Origin:|Access-Control-Allow-Methods:|Access-Control-Allow-Headers:|Access-Control-Allow-Credentials:|Allow:)' \
        > "$output_dir/$name.headers.txt" || true

    {
        printf 'method: %s\n' "$method"
        printf 'path: %s\n' "$path"
        printf 'status: %s\n' "$http_code"
        printf 'content-type: %s\n' "$content_type"
        if [[ -n "$request_body" ]]; then
            printf 'request-body: %s\n' "$request_body"
        fi
    } > "$output_dir/$name.meta.txt"

    rm -f "$raw_headers" "$raw_body"
    printf '%s  %s  %s\n' "$http_code" "$method" "$path"
}

capture news-list GET /rest/noticias
capture news-list-canonical GET /rest/unal-unal_news-unalNews
capture news-page-1 GET /rest/noticias/page/1
capture news-page-2 GET /rest/noticias/page/2
capture news-show-existing GET "/rest/noticias/show/$existing_uid"
capture news-show-missing GET "/rest/noticias/show/$missing_uid"
capture news-search POST /rest/noticias/search '{"size":3}'
capture news-all-new GET /rest/noticias/all/new/1
capture news-all-image GET /rest/noticias/all/image/1
capture news-all-video GET /rest/noticias/all/video/1
capture news-all-audio GET /rest/noticias/all/audio/1
capture news-autocomplete GET /rest/noticias/autocomplete/Universidad
capture news-deleted GET /rest/noticias/deleted
capture news-edited GET /rest/noticias/edited
capture news-options OPTIONS /rest/noticias
capture television-news-list GET /television/rest/noticias
capture news-invalid-page GET /rest/noticias/page/0
capture news-invalid-type GET /rest/noticias/all/document/1
capture visits-get-not-allowed GET /rest/visitas/update

if [[ -n "${CAPTURE_VISIT_UID:-}" ]]; then
    capture visits-update POST /rest/visitas/update "{\"news\":${CAPTURE_VISIT_UID}}"
    capture visits-update-canonical POST /rest/unal-unal_news-visitCounter/update "{\"news\":${CAPTURE_VISIT_UID}}"
    capture visits-missing-news POST /rest/visitas/update '{}'
fi
