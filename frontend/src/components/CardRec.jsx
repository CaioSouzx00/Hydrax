import React from 'react';
import { Link } from 'react-router-dom';

const CardRec = ({ produto, idsDesejados = [] }) => {
    const isDesejado = idsDesejados.includes(produto.id_produtos);
    
    const fotos = Array.isArray(produto.fotos) 
        ? produto.fotos 
        : (typeof produto.fotos === 'string' ? JSON.parse(produto.fotos) : []);
    const foto = Array.isArray(fotos) && fotos.length > 0 ? fotos[0] : null;
    
    const fotoUrl = foto ? `/storage/${foto}` : 'https://via.placeholder.com/400x400?text=Produto';
    const fornecedorFoto = produto.fornecedor?.foto 
        ? `/storage/${produto.fornecedor.foto}` 
        : 'https://via.placeholder.com/40x40?text=F';

    return (
        <div className="relative w-96 mr-12">
            <Link 
                to={`/produtos/${produto.id_produtos}/detalhes`} 
                className="block w-full h-full relative z-10"
            >
                <div className="bg-[#111]/50 border border-[#222] rounded-xl shadow-lg p-8 min-h-[580px] cursor-pointer hover:border-[#D5891B]/20 transition-all duration-200 flex flex-col">
                    {/* Imagem do produto */}
                    <div className="w-full mb-4">
                        <img 
                            src={fotoUrl}
                            alt="Imagem do Produto" 
                            className="w-full h-72 object-cover rounded-lg border border-[#D5891B]/20 shadow-sm" 
                        />
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

                        {/* Fornecedor */}
                        <div className="flex items-center space-x-2 mt-2">
                            <img 
                                className="rounded-full w-12 h-12" 
                                src={fornecedorFoto}
                                alt="Foto do fornecedor"
                            />
                            <span className="text-xs text-gray-400">
                                {produto.fornecedor?.nome_empresa || 'Fornecedor não informado'}
                            </span>
                        </div>
                    </div>
                </div>
            </Link>
        </div>
    );
};

export default CardRec;

