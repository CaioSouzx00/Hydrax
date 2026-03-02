import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import { listaDesejoAPI } from '../services/api';

const CardProduto = ({ produto, idsDesejados = [] }) => {
    const [isDesejado, setIsDesejado] = useState(idsDesejados.includes(produto.id_produtos));
    const [mainImage, setMainImage] = useState(null);
    
    const fotos = Array.isArray(produto.fotos) 
        ? produto.fotos 
        : (typeof produto.fotos === 'string' ? JSON.parse(produto.fotos) : []);
    const foto = Array.isArray(fotos) && fotos.length > 0 ? fotos[0] : null;
    
    const fotoUrl = mainImage || (foto ? `/storage/${foto}` : 'https://via.placeholder.com/400x400?text=Produto');
    const fornecedorFoto = produto.fornecedor?.foto 
        ? `/storage/${produto.fornecedor.foto}` 
        : 'https://via.placeholder.com/40x40?text=F';

    const handleWishlist = async (e) => {
        e.preventDefault();
        e.stopPropagation();
        
        try {
            if (isDesejado) {
                await listaDesejoAPI.destroy(produto.id_produtos);
                setIsDesejado(false);
            } else {
                await listaDesejoAPI.store(produto.id_produtos);
                setIsDesejado(true);
            }
        } catch (error) {
            console.error('Erro ao atualizar lista de desejos:', error);
        }
    };

    const notaMedia = produto.avaliacoes_avg_nota || 0;
    const avaliacoesCount = produto.avaliacoes?.length || 0;

    return (
        <div className="relative w-96 mx-auto group">
            <Link to={`/produtos/${produto.id_produtos}/detalhes`}>
                <div className="bg-[#111]/50 border border-[#222] rounded-xl shadow-lg p-8 min-h-[580px] cursor-pointer hover:border-[#D5891B]/30 transition-all duration-300 hover:shadow-lg hover:shadow-[#d5891b]/10">
                    
                    {/* Imagem principal */}
                    <div className="w-full mb-4 overflow-hidden rounded-lg relative">
                        <img
                            src={fotoUrl}
                            alt="Imagem do Produto"
                            className="w-full h-72 object-cover rounded-lg border border-[#D5891B]/20 shadow-sm"
                        />

                        {/* Miniaturas escondidas */}
                        {fotos && fotos.length > 1 && (
                            <div className="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-2 opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-all duration-300 z-50">
                                {fotos.map((miniatura, index) => (
                                    <img 
                                        key={index}
                                        src={`/storage/${miniatura}`}
                                        className="w-12 h-12 object-cover rounded-md border border-[#d5891b]/30 cursor-pointer hover:opacity-80 transition"
                                        onClick={(e) => {
                                            e.preventDefault();
                                            e.stopPropagation();
                                            setMainImage(`/storage/${miniatura}`);
                                        }}
                                        alt={`Miniatura ${index + 1}`}
                                    />
                                ))}
                            </div>
                        )}
                    </div>

                    {/* Conteúdo */}
                    <div className="flex flex-col space-y-3">
                        <h3 className="text-base font-semibold text-white truncate" title={produto.nome}>
                            {produto.nome}
                        </h3>

                        <p className="text-xs text-gray-400">{produto.categoria}</p>

                        <p className="text-white font-bold text-lg mt-1">
                            R$ {parseFloat(produto.preco).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                        </p>

                        <div className="flex items-center space-x-2 mt-2">
                            <img 
                                src={fornecedorFoto}
                                alt="Foto do fornecedor"
                                className="w-8 h-8 rounded-full object-cover border border-[#D5891B]/20"
                            />
                            <span className="text-xs text-gray-400">
                                {produto.fornecedor?.nome_empresa || 'Fornecedor não informado'}
                            </span>
                        </div>

                        {/* Estrelas */}
                        <div className="flex items-center space-x-2 mt-1">
                            <div className="flex items-center space-x-[1px]">
                                {[1, 2, 3, 4, 5].map((i) => {
                                    if (i <= Math.floor(notaMedia)) {
                                        return <span key={i} className="text-[#14ba88]">&#9733;</span>;
                                    } else if (i - 0.5 <= notaMedia) {
                                        return <span key={i} className="text-[#14ba88] opacity-50">&#9733;</span>;
                                    } else {
                                        return <span key={i} className="text-gray-600">&#9733;</span>;
                                    }
                                })}
                            </div>
                            {avaliacoesCount > 0 && (
                                <span className="text-xs text-gray-400">({avaliacoesCount} avaliações)</span>
                            )}
                        </div>
                    </div>
                </div>
            </Link>

            {/* Botão wishlist */}
            <form 
                onSubmit={handleWishlist}
                className="wishlist-form absolute top-3 right-3 z-20"
            >
                <button 
                    type="submit" 
                    className="w-8 h-8 flex items-center justify-center bg-[#071a1c] border border-[#d5891b]/30 rounded-lg hover:bg-[#222] transition active:scale-95"
                >
                    <svg 
                        xmlns="http://www.w3.org/2000/svg" 
                        className="w-5 h-5 text-[#d5891b]/70 transition-colors duration-300"
                        fill={isDesejado ? '#d5891b' : 'none'} 
                        viewBox="0 0 24 24" 
                        stroke="currentColor"
                    >
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 
                                4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 
                                4.5 0 00-6.364 0z" />
                    </svg>
                </button>
            </form>
        </div>
    );
};

export default CardProduto;

