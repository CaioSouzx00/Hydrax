import React from 'react';

const Footer = () => {
    return (
        <footer className="bg-black text-white w-full mt-16">
            <div className="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-sm">
                
                {/* Coluna 1 */}
                <div>
                    <ul className="space-y-3">
                        <li><a href="#" className="hover:underline">Cartão presente</a></li>
                        <li><a href="#" className="hover:underline">Guia de produtos</a></li>
                        <li><a href="#" className="hover:underline">Acompanhe seu pedido</a></li>
                    </ul>
                </div>

                {/* Coluna 2 */}
                <div>
                    <h3 className="font-semibold mb-3">Ajuda</h3>
                    <ul className="space-y-3">
                        <li><a href="#" className="hover:underline">Dúvidas gerais</a></li>
                        <li><a href="#" className="hover:underline">Encontre seu tamanho</a></li>
                        <li><a href="#" className="hover:underline">Entregas</a></li>
                        <li><a href="#" className="hover:underline">Pedidos</a></li>
                        <li><a href="#" className="hover:underline">Produtos</a></li>
                    </ul>
                </div>

                {/* Coluna 3 */}
                <div>
                    <h3 className="font-semibold mb-3">Sobre Hydrax</h3>
                    <ul className="space-y-3">
                        <li><a href="#" className="hover:underline">Propósito</a></li>
                        <li><a href="#" className="hover:underline">Sustentabilidade</a></li>
                        <li><a href="/quem-somos" className="hover:underline">Sobre o SURA, Inc.</a></li>
                    </ul>
                </div>

                {/* Coluna 4 */}
                <div className="space-y-6">
                    <div>
                        <h3 className="font-semibold mb-3">Redes sociais</h3>
                        <div className="flex space-x-4 text-2xl">
                            <a href="#" className="hover:text-[#1877F2]"><i className="fab fa-facebook"></i></a>
                            <a href="#" className="hover:text-[#E4405F]"><i className="fab fa-instagram"></i></a>
                            <a href="#" className="hover:text-[#FF0000]"><i className="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    <div>
                        <h3 className="font-semibold mb-3">Formas de pagamento</h3>
                        <div className="flex flex-wrap gap-3 items-center">
                            {/* Mastercard */}
                            <img src="https://img.icons8.com/color/48/mastercard-logo.png" className="h-8" alt="Mastercard" />

                            {/* Pix (SVG inline, sem depender de link externo) */}
                            <svg viewBox="0 0 64 64" className="h-8 w-8" role="img" aria-label="Pix" title="Pix">
                                {/* losango com cantos suavizados */}
                                <rect x="14" y="14" width="36" height="36" rx="10" ry="10"
                                      transform="rotate(45 32 32)" fill="#32BCAD"/>
                                {/* detalhes leves para lembrar o traço interno (opcional) */}
                                <path d="M22 32h20" stroke="white" strokeWidth="3" strokeLinecap="round" opacity="0.9"/>
                                <path d="M32 22v20" stroke="white" strokeWidth="3" strokeLinecap="round" opacity="0.9"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {/* Linha de baixo */}
            <div className="border-t border-gray-700 mt-6 py-4 text-center text-xs text-gray-400 flex flex-wrap justify-center gap-4">
                <a href="#" className="hover:underline">Brasil</a>
                <a href="/politica-privacidade" className="hover:underline">Política de privacidade</a>
                <a href="/politica-cookies" className="hover:underline">Política de cookies</a>
                <a href="/termos-de-uso" className="hover:underline">Termos de uso</a>
            </div>

            {/* Créditos */}
            <div className="text-center text-xs text-gray-500 px-6 pb-6">
                © 2025 Hydrax. Todos os direitos reservados. 
            </div>
        </footer>
    );
};

export default Footer;

