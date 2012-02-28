<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<xsl:template match="/">
		<!--     <html> -->
		<!--       <body> -->
		<xsl:for-each select="survey">
			<h1>
				<xsl:value-of select="@name"/>
			</h1>
			<!-- left the data for the form field blank so you can fill it in -->
			<form>
				<input type="hidden" name="survey">
					<xsl:attribute name="value">
						<xsl:value-of select="@name"/>
					</xsl:attribute>
				</input>
				<input type="hidden" name="showResults" value="true" />
				<xsl:for-each select="questions/question">
					<p>
						<xsl:value-of select="@text"/>
					</p>
					<ul>
						<xsl:for-each select="answer">
							<li>
								<input type="radio" value="alsoincorrect">
									<xsl:attribute name="name">
										<xsl:value-of select="../@id"/>
									</xsl:attribute>
									<xsl:attribute name="value">
										<xsl:value-of select="@text"/>
									</xsl:attribute>
								</input>
								<xsl:value-of select="@text"/>
							</li>
						</xsl:for-each>
					</ul>
				</xsl:for-each>
				<input type="submit"/>
			</form>
		</xsl:for-each>
		<!--       </body> -->
		<!--     </html> -->
	</xsl:template>
</xsl:stylesheet>
