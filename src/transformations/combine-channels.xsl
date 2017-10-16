<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet
  version="3.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
>
  <xsl:output method="xml" indent="yes" />
  <xsl:template match="/">
    <!-- xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="channels.xsd" -->
    <channels>
      <xsl:for-each select="//channel">
        <xsl:apply-templates select="document(.)/tv" />
      </xsl:for-each>
    </channels>
  </xsl:template>
  <xsl:template match="tv">
    <channel>
      <name><xsl:value-of select="programme[1]/@channel" /></name>
      <date><xsl:value-of select="concat(substring(programme[1]/@start, 1, 4), '-', substring(programme[1]/@start, 5, 2), '-', substring(programme[1]/@start, 7, 2))" /></date>
      <logo>http://chanlogos.xmltv.se/<xsl:value-of select="programme[1]/@channel" />.png</logo>
      <xsl:for-each select="programme">
        <show>
          <title><xsl:value-of select="title" /></title>
          <start><xsl:value-of select="concat(substring(@start, 9, 2), ':', substring(@start, 11, 2))" /></start>
          <description><xsl:value-of select="desc" /></description>
        </show>
      </xsl:for-each>
    </channel>
  </xsl:template>
</xsl:stylesheet>
