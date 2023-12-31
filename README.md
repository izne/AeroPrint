# AeroPrint
Scripts for Thermal network printers that talk ESC/POS commands.

# Flow

Data &rarr; Template &rarr; Printer

# Pre-requisites
Bash, PHP, ESC/POS printer

# Example with Flight simulation data
In addition to all the nice flight dispatch documents generated by SimBrief, a few small receipts in key moments would be nice during a VATSIM flight:
- METAR/TAF on startup and TOD
- (ICAO) Flight plan
- Fuel
- Weight and balance
- PERF calculations
- IFR Clearance and departure "sheet"

A handful of cases where we can print a receipt, use it during the flight and later attach it to the documents for archiving.

# How it works
There is a ESC/POS template (e.g. metar.esc). It contains commands for the printer, much like script for formatting the output on the receipt.

Inside the template file there are placeholders, like %localTime% and %metarData%. They are used to inject the live data. 

The .shell script:
 - Runs the PHP script, which:
    - fetches data from METAR from VATSIM or FPL from SIMBRIEF)
    - loads the template: standard template esc.pos
    - injects the live data
 - Stores the output (temp.prn) as a temporary file
 - Runs senddat.exe, sending temp.prn over the Ethernet to the IP:PORT of a BIXOLON SRP-300 printer
  - Removes the temporary temp.prn file

# Result
![METAR](/images/metar.jpg "METAR Receipt")
![SIMBRIEF](/images/simbrief.jpg "SIMBRIEF Receipt")


# References
[BIXOLON SRP-300 ESC/POS Commands Reference](https://bixolon.com/_upload/manual/Manual_Command_Thermal_POS_Printer_ENG_V1.00[25].pdf)

[ESC/POS Examples](https://reference.epson-biz.com/modules/ref_escpos/index.php?content_id=272)

[SENDDAT.EXE Tool from EPSON](https://download.epson-biz.com/modules/pos/index.php?page=single_soft&cid=5027&scat=47&pcat=3)

[Validate barcodes with this tool](https://barcode.tec-it.com/de/Code39FullASCII?data=Aa-1234)