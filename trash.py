
import requests
from bs4 import BeautifulSoup

# Base URL of the website
base_url = "https://dbtgoa.gov.in/"  # Replace with the actual base URL

op = open("output2.txt",'w')

html_content = "".join(open('trash.html','r',encoding='utf-8').readlines())

soup = BeautifulSoup(html_content, 'html.parser')

departments = {}

# Find all div elements with class "col-sm-12 col-md-6"
divs = soup.find_all('div', class_='col-sm-12 col-md-6')
count = 1
for div in divs:
    # Extract the department name from the h3 element
    department_name = div.find('h3').text.split(':')[0].strip()

    schemes = []

    # Find all li elements under this department
    li_elements = div.find_all('li')

    for li in li_elements:
        scheme_name = li.text.strip()
        scheme_url = li.find('a')['href']
        
        # Make a request to the scheme detail page
        full_url = base_url + scheme_url
        response = requests.get(full_url)
        scheme_soup = BeautifulSoup(response.content, 'html.parser')

        # Extract the scheme description
        description_div = scheme_soup.find('div', class_='col-sm-12 margin_top10 margin-left-15')
        scheme_description = description_div.text.strip() if description_div else 'No description found'

        # Store the scheme name and its description
        schemes.append({
            'name': scheme_name,
            'description': scheme_description
        })
        print(count)
        count+=1
        print(f"""
            [
                'name' => '{scheme_name}',
                'description'=> '{scheme_description}',
                'dept_id' => '{department_name}'
            ],
                """,file=op)

    # Add the department and its schemes to the dictionary
    departments[department_name] = schemes

# Print the results
for department, schemes in departments.items():
    print(f"Department: {department}")
    for scheme in schemes:
        print(f"  Scheme: {scheme['name']}")
        print(f"  Description: {scheme['description']}\n")
