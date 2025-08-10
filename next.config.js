module.exports = {
  reactStrictMode: true,
  // Desativar source maps em produção para dificultar engenharia reversa
  productionBrowserSourceMaps: false,
  // Configuração de segurança adicional
  headers: async () => [
    {
      source: '/(.*)',
      headers: [
        {
          key: 'X-Content-Type-Options',
          value: 'nosniff'
        },
        {
          key: 'X-Frame-Options',
          value: 'DENY'
        },
        {
          key: 'X-XSS-Protection',
          value: '1; mode=block'
        }
      ]
    }
  ]
};
