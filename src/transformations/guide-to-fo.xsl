<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet
  version="3.0"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
>
  <xsl:output method="xml" indent="yes" />
  <xsl:template match="/">
    <!-- xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="channels.xsd" -->
    <fo:root xmlns:fo="http://www.w3.org/1999/XSL/Format">
      <fo:layout-master-set>
        <fo:simple-page-master master-name="A4">
          <!-- Page template goes here -->
          <fo:region-body margin-top="3cm" />
        </fo:simple-page-master>
      </fo:layout-master-set>
      <fo:page-sequence master-reference="A4">
        <!-- Page content goes here -->
        <fo:flow flow-name="xsl-region-body">
          <fo:block space-after="4pt">
            <fo:wrapper font-size="14pt" font-weight="bold">
              Waffles with Syrup
            </fo:wrapper>
          </fo:block>
        </fo:flow>
      </fo:page-sequence>
    </fo:root>
  </xsl:template>
</xsl:stylesheet>
