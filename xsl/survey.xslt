<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="/">
		<html>
			<body>
				<h1>Survey Results</h1>
				<xsl:for-each select="surveys/survey">
					<h2>
						<xsl:value-of select="name"/>
					</h2>
					<xsl:for-each select="questions/question">
						<p>
							<xsl:value-of select="question_text"/>
						</p>
						<ul>
							<xsl:for-each select="answer">
								<li>
									<xsl:value-of select="answer_text"/>
									-
									<xsl:value-of select="@count"/>
								</li>
							</xsl:for-each>
						</ul>
					</xsl:for-each>
				</xsl:for-each>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>
