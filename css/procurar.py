import os

diretorio = 'C:\\xampp\\htdocs\\site\\petstop\\js'
palavra_procurada = 'pet-shop-df-banho-e-tosa'

for raiz, diretorios, arquivos in os.walk(diretorio):
    for arquivo in arquivos:
        if arquivo.endswith('.js'):
            caminho_arquivo = os.path.join(raiz, arquivo)
            with open(caminho_arquivo, 'r', encoding='utf-8') as f:
                if palavra_procurada in f.read():
                    print(f'A palavra "{palavra_procurada}" foi encontrada em {caminho_arquivo}')
