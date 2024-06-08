import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}

module.exports = {
    plugins: [
      require('@tailwindcss/aspect-ratio'),
    ],
  }
