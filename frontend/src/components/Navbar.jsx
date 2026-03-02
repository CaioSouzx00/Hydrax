import React, { useState, useEffect, useRef } from 'react';
import { Link } from 'react-router-dom';
import { usuarioAPI } from '../services/api';

const Navbar = ({ usuario, onBuscar, carrinhoQuantidade = 0, wishlistCount = 0, pedidosCount = 0 }) => {
    const [showUserMenu, setShowUserMenu] = useState(false);
    const [showOverlay, setShowOverlay] = useState(false);
    const [buscaTermo, setBuscaTermo] = useState('');
    const userDropdownRef = useRef(null);
    const overlayRef = useRef(null);

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (userDropdownRef.current && !userDropdownRef.current.contains(event.target)) {
                setShowUserMenu(false);
                setShowOverlay(false);
            }
        };

        if (showUserMenu) {
            document.addEventListener('mousedown', handleClickOutside);
        }

        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, [showUserMenu]);

    const handleLogout = async (e) => {
        e.preventDefault();
        try {
            await usuarioAPI.logout();
            window.location.href = '/login';
        } catch (error) {
            console.error('Erro ao fazer logout:', error);
        }
    };

    const handleBuscar = (e) => {
        e.preventDefault();
        if (onBuscar) {
            onBuscar(buscaTermo);
        }
    };

    return (
        <>
            <header className="fixed top-0 left-0 w-full z-50 backdrop-blur-md bg-gradient-to-br from-[#211828]/90 via-[#0b282a]/90 to-[#17110d]/90ss border-b border-[#7f3a0e] shadow-sm">
                <div className="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                    {/* Logo */}
                    <div className="flex items-center gap-3">
                        <Link to="/">
                            <img src="/imagens/hydrax/HYDRA'x.png" alt="Hydrax Logo" className="h-14" />
                        </Link>
                    </div>

                    {/* Menu principal */}
                    <nav className="hidden md:flex items-center gap-6 text-sm">
                        {/* Busca estilizada */}
                        <div className="relative flex items-center w-44 transition-all duration-500 ease-in-out focus-within:w-64 bg-white/10 rounded-2xl px-3 py-1.5 text-white ring-0 ring-[#14ba88] focus-within:ring-2 focus-within:ring-[#c87f17]/70 shadow-md overflow-hidden">
                            <input 
                                type="text" 
                                id="buscar_produto"
                                placeholder="Buscar"
                                className="bg-transparent outline-none text-sm placeholder-white/80 w-full transition-all duration-300 focus:placeholder-transparent"
                                autoComplete="off"
                                aria-label="Buscar produto"
                                value={buscaTermo}
                                onChange={(e) => setBuscaTermo(e.target.value)}
                                onKeyPress={(e) => e.key === 'Enter' && handleBuscar(e)}
                            />
                            <button 
                                id="botao_buscar" 
                                type="button" 
                                onClick={handleBuscar}
                                className="ml-2 transform transition-transform duration-300 hover:scale-125 hover:text-[#e29b37]"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" className="w-4 h-4 text-[#c87f17]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-3.35z" />
                                </svg>
                            </button>
                        </div>

                        {!usuario ? (
                            <>
                                {/* Links para visitante */}
                                <Link 
                                    to="/usuarios/cadastrar"
                                    className="relative rounded-2xl px-5 py-2.5 overflow-hidden group bg-[#14ba88] hover:bg-gradient-to-r hover:from-[#14ba88] hover:to-[#1ce0a5] hover:ring-2 hover:ring-offset-2 hover:ring-[#1ce0a5] transition-all ease-out duration-300"
                                >
                                    <span className="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                                    <span className="relative">Cadastrar</span>
                                </Link>

                                <Link 
                                    to="/login"
                                    className="relative inline-flex items-center justify-start px-5 py-2.5 font-bold rounded-2xl group overflow-hidden"
                                >
                                    <span className="w-32 h-32 rotate-45 translate-x-12 -translate-y-2 absolute left-0 top-0 bg-white opacity-[3%]"></span>
                                    <span className="absolute top-0 left-0 w-48 h-48 -mt-1 transition-all duration-500 ease-in-out rotate-45 -translate-x-56 -translate-y-24 bg-white opacity-100 group-hover:-translate-x-8"></span>
                                    <span className="relative w-full text-left text-white group-hover:text-gray-900">Entrar</span>
                                    <span className="absolute inset-0 border-2 border-white rounded-2xl"></span>
                                </Link>
                            </>
                        ) : (
                            <>
                                {/* Usuário logado */}
                                <div 
                                    ref={userDropdownRef}
                                    className="relative inline-block text-left" 
                                    id="user-dropdown"
                                    onMouseEnter={() => {
                                        setShowUserMenu(true);
                                        setShowOverlay(true);
                                    }}
                                    onMouseLeave={() => {
                                        setTimeout(() => {
                                            setShowUserMenu(false);
                                            setShowOverlay(false);
                                        }, 150);
                                    }}
                                >
                                    <div id="user-name" className="flex items-center space-x-2">
                                        <div className="w-8 h-8 bg-[#d5891b] rounded-full flex items-center justify-center hover:bg-[#d5891b] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" className="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                            </svg>
                                        </div>
                                        <span className="mr-4 cursor-pointer font-semibold hover:text-[#d5891b] transition-colors">
                                            Olá, {usuario.nome_completo} ▾
                                        </span>
                                    </div>

                                    {/* Menu logout */}
                                    {showUserMenu && (
                                        <div 
                                            id="logout-menu"
                                            className="absolute right-0 bg-[#211828]/80 border border-[#7f3a0e] rounded-md shadow-lg mt-2 py-2 min-w-[140px] z-50"
                                        >
                                            {/* Perfil */}
                                            <Link 
                                                to="/painel"
                                                className="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-white hover:bg-[#d5891b]/30 transition-colors"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" className="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                                        d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.779.755 6.879 2.041M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span>Perfil</span>
                                            </Link>
                                            {/* IA */}
                                            <Link 
                                                to="/IA"
                                                className="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-white hover:bg-[#d5891b]/30 transition-colors"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" className="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 7h10v10H7V7z" />
                                                </svg>
                                                <span>IA</span>
                                            </Link>
                                            {/* Logout */}
                                            <form onSubmit={handleLogout}>
                                                <button 
                                                    type="submit"
                                                    className="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-white hover:bg-[#d5891b]/30 transition-colors"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" className="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                                            d="M17 16l4-4m0 0l-4-4m4 4H7" />
                                                    </svg>
                                                    <span>Sair</span>
                                                </button>
                                            </form>
                                        </div>
                                    )}
                                </div>
                            </>
                        )}

                        {/* Carrinho */}
                        <Link to="/carrinho" className="relative hover:text-gray-300 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" className="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13L17 13M7 13H5.4" />
                            </svg>
                            {carrinhoQuantidade > 0 && (
                                <span className="absolute -top-2 -right-2 bg-[#c87f17]/90 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center animate-bounce shadow-lg">
                                    {carrinhoQuantidade}
                                </span>
                            )}
                        </Link>

                        {/* Lista de Desejos */}
                        <Link to="/lista-desejos" className="relative hover:text-gray-300 transition ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" className="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 
                                        4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 
                                        4.5 0 00-6.364 0z" />
                                </svg>
                            {wishlistCount > 0 && (
                                <span className="absolute -top-2 -right-2 bg-[#c87f17]/90 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center animate-bounce shadow-lg">
                                    {wishlistCount}
                                </span>
                            )}
                        </Link>

                        {/* Minhas Compras */}
                        <Link to="/meus-pedidos" className="relative hover:text-gray-300 transition ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                className="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                    d="M3 7h18M3 7l1.5 12h15L21 7M16 11a4 4 0 11-8 0" />
                            </svg>
                            {pedidosCount > 0 && (
                                <span className="absolute -top-2 -right-2 bg-[#c87f17]/90 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center animate-bounce shadow-lg">
                                    {pedidosCount}
                                </span>
                            )}
                        </Link>
                    </nav>
                </div>
            </header>

            {/* Overlay */}
            <div 
                ref={overlayRef}
                id="overlay"
                className={`fixed inset-0 bg-black/50 transition-opacity duration-300 z-40 pointer-events-none ${showOverlay ? 'opacity-50 pointer-events-auto' : 'opacity-0'}`}
                onClick={() => {
                    setShowUserMenu(false);
                    setShowOverlay(false);
                }}
            />

            {/* Sidebar Mobile */}
            {!usuario && (
                <>
                    <input type="checkbox" id="menu-toggle" className="hidden peer" />
                    <label 
                        htmlFor="menu-toggle"
                        className="fixed top-4 left-5 z-50 text-white text-2xl p-2 cursor-pointer peer-checked:hidden hover:text-[#a68e7b]"
                    >
                        ☰
                    </label>
                    <aside className="fixed top-0 left-0 h-full w-64 bg-gradient-to-br from-[#211828]/90 via-[#0b282a]/90 to-[#17110d]/90 backdrop-blur-md text-white z-50 transform -translate-x-full peer-checked:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl border-r border-[#d5891b]/30">
                        <label 
                            htmlFor="menu-toggle"
                            className="absolute top-4 right-4 text-white text-2xl cursor-pointer hover:text-[#a68e7b] transition"
                        >
                            ✕
                        </label>
                        <div className="mt-16 px-4 py-6">
                            <div className="flex justify-center mb-6">
                                <img src="/imagens/hydrax/HYDRAX - LOGO1.png" alt="Hydrax Logo" className="h-40 opacity-90 hover:opacity-100 transition" />
                            </div>
                            <hr className="border-[#d5891b]/40 mb-4" />
                            <nav className="space-y-3 text-sm">
                                <Link 
                                    to="/admin/login"
                                    className="block px-4 py-2 rounded-md bg-[#14ba88] hover:bg-[#2d4e50] transition shadow-md"
                                >
                                    Administrador
                                </Link>
                                <Link 
                                    to="/fornecedores/login"
                                    className="block px-4 py-2 rounded-md bg-[#14ba88] hover:bg-[#2d4e50] transition shadow-md"
                                >
                                    Fornecedor
                                </Link>
                            </nav>
                            <hr className="border-[#d5891b]/40 mt-6" />
                            <p className="text-xs text-center text-green-200 mt-6">
                                &copy; 2025 <strong className="text-[#14ba88]">Hydrax</strong>
                            </p>
                        </div>
                    </aside>
                </>
            )}

            <style>{`
                @keyframes bounce {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-3px); }
                }
                .animate-bounce {
                    animation: bounce 1s infinite;
                }
            `}</style>
        </>
    );
};

export default Navbar;

