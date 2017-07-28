USE [etools_desenvolvimento]
GO

/****** Object:  Table [dbo].[T013_MODELO]    Script Date: 17/03/2017 16:31:23 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[comandos](
	[id_comando] [decimal](10, 0) NOT NULL,
	[nome] varchar(300) NULL,
	[comando_sql] varchar(5000) NULL,
	[descricao] VARCHAR(5000) NULL,
	[dt_cad] datetime NULL,
	[dt_alt] datetime NULL,
	[id_pessoa_cad] int NULL,
	[id_pessoa_alt] int NULL,
 CONSTRAINT [PK__comando] PRIMARY KEY CLUSTERED 
(
	[id_comando] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, FILLFACTOR = 90) ON [PRIMARY]
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO
