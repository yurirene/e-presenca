# e-Presença
## Sistema simples de Gestão de Presença com QR Code para Congressos de UMP.
### Utilizando: ORM Doctrine, API básica, MVC com Requisições em AJAX;

Nesse Sistema é possível:
- Cadastrar as Igrejas
- Cadastrar os Delegados com as informações: Nome, Igreja e Código QR.
- Cadastrar as Sessões (Verificação de Poderes, 1ª - 6ª Sessão Regular)
- Utilizar leitura de QR Code para registrar a presença do delegado
- Obter a Lista de Presença por Sessão

-- Observação: Nesse sistema não é gerado o QR Code, você pode gerar em sistemas de terceiros e apenas inserir o código ao cadastrar o delegado.

#### Futuras features
- Exportar a lista de delegados contendo (código, igreja e nome) em JSON e importar nos demais Sistemas (SISVOTO, SIEM).
- Gerar o código QR e automaticamente cadastrar.
