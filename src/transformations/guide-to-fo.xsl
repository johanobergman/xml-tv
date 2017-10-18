<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet
  version="3.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
>
  <xsl:output method="xml" indent="yes" />
  <xsl:param name="date" required="yes" />
  <xsl:template match="/">
    <fo:root xmlns:fo="http://www.w3.org/1999/XSL/Format">
      <fo:layout-master-set>
        <fo:simple-page-master master-name="A4">
          <fo:region-body margin="1cm" margin-top="1.5cm" column-count="3" column-gap="1cm" />
          <fo:region-before extent="1cm" background-color="silver" />
        </fo:simple-page-master>
      </fo:layout-master-set>
      <fo:page-sequence master-reference="A4">
        <fo:static-content flow-name="xsl-region-before">
          <fo:block margin-top=".3cm" font-size="12pt" text-align="center">TV-guide - <xsl:value-of select="$date" /></fo:block>
        </fo:static-content>
        <fo:flow flow-name="xsl-region-body">
          <xsl:for-each select="//channel">
            <fo:block space-after="4pt" break-before="page">
              <!-- Logo and title -->
              <fo:block text-align="center" font-size="14pt" font-weight="bold" space-after="6pt">
                <fo:external-graphic src="url('{logo}')" width="100" height="100" content-height="scale-to-fit" scaling="non-uniform" />
              </fo:block>
              <fo:block font-size="14pt" font-weight="bold" space-after="6pt">
                <xsl:value-of select="name" />
              </fo:block>
              <!-- Every show for the channel -->
              <xsl:for-each select="show">
                <fo:block space-after="8pt">
                  <fo:block font-size="12pt">
                    <fo:inline font-weight="bold"><xsl:value-of select="start" /></fo:inline>
                    &#160;<xsl:value-of select="title" />
                  </fo:block>
                  <fo:block font-size="8pt" color="gray">
                    <xsl:value-of select="description" />
                  </fo:block>
                </fo:block>
              </xsl:for-each>
            </fo:block>
          </xsl:for-each>
        </fo:flow>
      </fo:page-sequence>
    </fo:root>
  </xsl:template>
</xsl:stylesheet>
