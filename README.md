# Satdesign Vertical Carousel

Een WordPress plugin die een verticale afbeeldingen carousel widget toevoegt aan Elementor met een oneindige loop functionaliteit.

## Beschrijving

Satdesign Vertical Carousel is een custom Elementor widget waarmee je een stijlvolle verticale carousel kunt toevoegen aan je WordPress website. De carousel ondersteunt oneindige loop animatie en is volledig aanpasbaar via de Elementor interface.

## Features

- Verticale carousel layout
- Oneindige loop animatie
- Volledig geïntegreerd met Elementor
- Eenvoudige configuratie via Elementor's drag & drop interface
- Responsive design
- Custom styling opties

## Vereisten

- WordPress 5.0 of hoger
- PHP 7.0 of hoger
- Elementor Page Builder (geïnstalleerd en geactiveerd)

## Installatie

1. Upload de `satdesign-vertical-carousel` map naar de `/wp-content/plugins/` directory
2. Activeer de plugin via het 'Plugins' menu in WordPress
3. Zorg ervoor dat Elementor is geïnstalleerd en geactiveerd
4. De widget is nu beschikbaar in het Elementor widget paneel

## Gebruik

1. Open een pagina in Elementor Editor
2. Zoek naar "Vertical Carousel" in het widgets paneel
3. Sleep de widget naar je gewenste locatie
4. Configureer de carousel instellingen in het linker paneel
5. Voeg afbeeldingen toe en pas de styling aan
6. Publiceer of update je pagina

## Bestandsstructuur

```
satdesign-vertical-carousel/
├── assets/
│   ├── css/
│   │   └── vertical-carousel.css
│   └── js/
│       └── vertical-carousel.js
├── widgets/
│   └── vertical-carousel-widget.php
├── satdesign-vertical-carousel.php
└── README.md
```

### Bestanden uitleg

- `satdesign-vertical-carousel.php` - Hoofd plugin bestand
- `widgets/vertical-carousel-widget.php` - Elementor widget class
- `assets/css/vertical-carousel.css` - Carousel styling
- `assets/js/vertical-carousel.js` - Carousel functionaliteit en animatie

## Ontwikkeling

### Plugin Structuur

De plugin gebruikt een singleton pattern voor initialisatie en integreert met Elementor via hooks:

- `elementor/widgets/register` - Registreert de custom widget
- `elementor/frontend/after_register_scripts` - Registreert frontend scripts
- `elementor/frontend/after_register_styles` - Registreert frontend styles

### Aanpassingen maken

Om de carousel aan te passen:

1. **Styling**: Bewerk `assets/css/vertical-carousel.css`
2. **Functionaliteit**: Bewerk `assets/js/vertical-carousel.js`
3. **Widget opties**: Bewerk `widgets/vertical-carousel-widget.php`

## Versie geschiedenis

### 1.0.0
- Eerste release
- Verticale carousel met oneindige loop
- Elementor integratie

## Auteur

**Satdesign**

## Licentie

WordPress GPL licentie

## Support

Voor vragen of problemen, neem contact op met SatDesign.
