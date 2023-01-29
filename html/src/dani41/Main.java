package dani41;

//Import needed depedencies
import java.io.File;
import java.util.Scanner;
import java.io.FileWriter;
import java.io.IOException;
import java.io.FileNotFoundException;
import java.nio.file.Path;

//Import pdfbox
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.text.PDFTextStripper;
public class Main {

    // Hold path of the file
    static String cwd = Path.of("").toAbsolutePath().toString();

    // Function to create file
    public static String CreateFile(String name) {
        return cwd+ "/converted_file/" + name + "_Converted.txt";}
    
    // Function to read file
    public static String ReadFile() throws FileNotFoundException {
        try {
            File myObj = new File(cwd + "/log.txt");
            Scanner myReader = new Scanner(myObj);
            StringBuilder bld = new StringBuilder();
            while (myReader.hasNextLine()) {
                bld.append(myReader.nextLine());

            }
            String data = bld.toString();
            myReader.close();
            return data;
        } catch (FileNotFoundException e) {
            e.printStackTrace();
            return "";
        }
    }

    // Function to read file
    public static void WriteFile(String file_name, String content) {
        
        if (!file_name.equals(""))
        {
            try {
                FileWriter myWriter = new FileWriter(file_name);
                myWriter.write(content);
                myWriter.close();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

    public static void main(String[] args) throws  IOException{

        //Define file name
        String file_name = ReadFile();
        String file_exten = ".pdf";

        //Define path name of uploaded file
        //Get it from log.txt
        String path_name = cwd + "/uploaded_file/" + file_name + file_exten;



        //Loading an existing document
        File file = new File(path_name);
        PDDocument document = PDDocument.load(file);

        //Instantiate PDFTextStripper class
        PDFTextStripper pdfStripper = new PDFTextStripper();

        //Retrieving text from PDF document
        String text = pdfStripper.getText(document);

        //Create and write to new txt file
        WriteFile(CreateFile(file_name), text);

        //Closing the document
        document.close();
    }

}


