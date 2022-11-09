/**
 * Stylelint config file
 * as configured in package.json under stylelint.extends
 *
 * @docs Stylelint https://stylelint.io/user-guide/
 * @docs StylelintWebpackPlugin: https://webpack.js.org/plugins/stylelint-webpack-plugin/
 * @docs stylelint-scss : https://github.com/kristerkari/stylelint-scss
 * @since 1.0.0
 */

module.exports = {
    extends: ["stylelint-config-standard-scss","@wordpress/stylelint-config"],
    plugins: [
        "stylelint-scss"
    ],
    rules:   {
        "rule-empty-line-before": ["always", {"ignore": ["after-comment","inside-block"]}],
        "no-eol-whitespace": [ true, { "ignore": ["empty-lines"]}],
        "declaration-property-unit-whitelist" : {
            "/^animation/": ["s", "ms"],
            "line-height": ["px", "em", "rem"]
          },
        "max-line-length":         180,
        // "no-empty-source":         null,
        "indentation":             2,
        "at-rule-no-unknown":      null,
        "scss/at-rule-no-unknown": true,
        "scss/at-rule-no-unknown": true,
    },
}