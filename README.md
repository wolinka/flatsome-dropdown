[🇹🇷 Türkçe (Turkish)](README-tr.md) | [🇬🇧 English](README.md)

# Flatsome Classic Dropdown Plugin

A lightweight, plug-and-play WordPress plugin that transforms Flatsome's default complex mega-menu logic into a clean, classic, multi-level dropdown menu.

## 🚀 Features

* **Classic Multi-Level Dropdowns:** Strips out the rigid grid/mega-menu structural HTML of Flatsome and provides a sleek, nested dropdown menu hierarchy that just works!
* **Native Customizer Integration:** 100% synchronized with Flatsome's native **All Dropdowns** and **Default Dropdowns** Customizer settings. Your color, border, shadow, text color (Light/Dark mode), and typography choices apply automatically.
* **Custom Dropdown Width Setting:** Introduces an exclusive "Dropdown Width (px)" setting straight into Flatsome's `Header -> Dropdown Style` Customizer panel to let you manage your menu's width instantly.
* **Smart Mobile Fallback:** Strictly isolates its behavior to desktop menus. Flatsome's original `FlatsomeNavSidebar` and mobile off-canvas accordion behaviors remain untouched and natively intact.
* **Secure by Design:** Built strictly under WordPress best-practices including comprehensive output escaping (`wp_kses_post`, `esc_attr`), strict RGB/HEX Customizer color sanitization, and proper user capability checks (`edit_theme_options`).

## ⚙️ Installation

1. Download or clone this repository to your computer.
2. Upload the `flatsome-dropdown` folder to the `/wp-content/plugins/` directory of your WordPress installation.
3. Activate the plugin through the **Plugins** menu in WordPress.
4. *(Optional but recommended)* Navigate to **Appearance > Customize > Header > Dropdown Style** to tweak your colors or define a specific dropdown width!

## 🔧 How It Works

Right out of the box, the plugin attaches a custom `Walker_Nav_Menu` (`Flatsome_Dropdown_Walker`) globally to your Flatsome header locations. It cleans up the DOM, converts Flatsome's grid-based `nav-dropdown` output into a standard nested `<ul class="sub-menu">` list, and overrides the default menu-related CSS with gracefully animated CSS transitions.

Hovering items instantly pushes nested sub-menus (Level 2+) properly to the right bounds of their parent.

## 🛡️ Security
This plugin was thoroughly audited for output sanitation:
- `esc_attr` and `absint` validations used for all dynamic Customizer CSS generation.
- Custom RGBA/HEX safe filter applied dynamically (so Flatsome's alpha-channel color picker continues to operate smoothly).
- Menu titles undergo strict HTML filtering via `wp_kses_post()`.

## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change!

---
Built by [Özlem Çimen](https://www.linkedin.com/in/ozlemcimen/) — 
Enterprise WordPress consulting at [Wolinka](https://wolinka.com.tr)
