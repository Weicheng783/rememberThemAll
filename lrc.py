import json
import re

def parse_lrc_file(file_path):
    with open(file_path, 'r', encoding='gb2312') as file:
        lines = file.readlines()

    parsed_lines = []
    for line in lines[7:]:  # Exclude the first 7 rows
        line = line.strip()
        if line.startswith('['):
            line = line[line.find(']') + 1:]  # Remove the opening bracket and timestamp
        else:
            line = line.split(' ', 1)  # Split into two halves at the first whitespace
            if len(line) > 1:
                line = line[1]  # Take the second half
            else:
                line = line[0]  # Keep the original line if there is no whitespace

        if(line != ""):
            parsed_lines.append(line)

    # print(parsed_lines)
    return parsed_lines

# Provide the path to your LRC file
for i in range(1, 37):
    lrc_file_path = './tem4/Lesson ' + str(i) + '.lrc'
    output_file_path = './word_lists/Lesson ' + str(i) + '.txt'
    config_file_path = './configs/Lesson ' + str(i) + '.json'
    parsed_lines = parse_lrc_file(lrc_file_path)

    config = []

    with open(output_file_path, 'w') as output_file:
        with open(config_file_path, 'w') as config_file:
            for line in parsed_lines:
                temp = line.split(" ")
                if temp != [''] and re.match(r"^[a-zA-Z]+$", temp[0].replace("(","").replace(")","").replace("-","")) is not None:
                    output_file.write(temp[0].replace("(","").replace(")","").replace("-","") + ',')
                    remains = ""
                    for i in range(1,len(temp)):
                        remains += temp[i] + " "
                    # Create a JSON object
                    config.append({"start": "0", "finish": "0", "word": temp[0].replace("(","").replace(")","").replace("-",""), "meaning": remains})
                # Write the JSON object to the config file
            json.dump(config, config_file)
