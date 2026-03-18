#!/bin/bash

set -ex

PLUGIN_NAME='vk-filter-search'
PLUGIN_DIR=$(cd $(dirname $(dirname $0)); pwd)

dist_dir="${PLUGIN_DIR}/dist"
src_dir="${dist_dir}/${PLUGIN_NAME}"
ZIPBALL="${dist_dir}/${PLUGIN_NAME}.zip"
DISTIGNORE="${PLUGIN_DIR}/.distignore"

[[ -e "${dist_dir}" ]] || mkdir "${dist_dir}"
[[ -e "${ZIPBALL}" ]] && rm -r "${ZIPBALL}"
[[ -e "${src_dir}" ]] && rm -rf "${src_dir}"

rsync -av "${PLUGIN_DIR}/" "${src_dir}/" --exclude="dist/" --exclude-from="${DISTIGNORE}"

cd "${dist_dir}"

zip -r "${ZIPBALL}" "${PLUGIN_NAME}/"

exit 0
