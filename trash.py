"""from bs4 import BeautifulSoup
import json

html_content = "".join(open('trash.html','r').readlines())
html_content= html_content.replace("\n","")
of = open("output.txt",'w')
soup = BeautifulSoup(html_content, 'html.parser')
departments = {}
department_id = 1

for department_div in soup.find_all("div", class_="col-md-6"):
    department_name = department_div.find("div", class_="pageSubHeading borderBottom").text.split(':')[0].strip()
    schemes = [li.text for li in department_div.find_all("li")]
    departments[department_id] = schemes
    department_id += 1

json_output = json.dumps(departments, indent=4)
print(json_output,file=of)
"""

from flask import Flask, jsonify, request

app = Flask(__name__)

# The storage dictionary containing department IDs and their respective schemes
storage_dictionary = {
    "1": [
        "Agricultural Extension",
        "AgEdn - National Talent Scholarship UG",
        "AgEdn - Merit Cum Means scholarship",
        "AgEdn - Post Matric Scholarship",
        "AgEdn - Students READY",
        "AgEdn - ICAR Emeritus Scientist",
        "AgEdn - ICAR Emeritus Professor",
        "AgEdn - Netaji Subhas ICAR International Fellowship",
        "AgEdn - ICAR Junior Research Fellowship",
        "AgEdn - ICAR Senior Research Fellowship",
        "AgEdn - India-Africa Fellowship",
        "AgEdn - India-Afghanistan Fellowship",
        "AgEdn - National Talent Scholarship PG",
        "AS_NDRI_Institute Scholarship for M.Sc. and Ph.D.",
        "FS - CIFE - Institutional Fellowship",
        "CS- IARI Scholarship",
        "AgEdn - ICAR National Professor and National Fellow",
        "IASRI Scholarship for MSc and PhD",
        "AS_IVRI_Institute Scholarship for M.V.Sc. and Ph.D."
    ],
    "2": [
        "Krishi Unnati Yojana (KUY)-MOVCDNER",
        "Pradhan Mantri Fasal Bima Yojna",
        "Sub-Mission on Seeds and Planting Material",
        "National Food Security Mission - NFSM",
        "Sub Mission on Agriculture Mechanization-Centrally Sponsored",
        "NMSA-Rainfed AreaDevelopment",
        "RKVY (RAFTAAR)",
        "Mission for Integrated Development of Horticulture",
        "Per Drop More Crop",
        "Agri Clinics and Agri Business Centres ACABC",
        "Agriculture Technology Management Agency (ATMA) - Extension Functionaries",
        "Agriculture Technology Management Agency (ATMA)- Farmers",
        "Sub Mission on Agriculture Mechanization-Central Sector",
        "PM KISAN",
        "National Mission on Edible Oil-Oilpalm"
    ],
    "3": [
        "Livestock Health and Diseases Control"
    ],
    "4": [
        "Raja Ramanna Centre for Advanced technology RRCAT-Opportunities of Projects in RRCAT for Students",
        "Advanced Centre for Treatment, Research, and Education in Cancer ACTREC-Phd Programme",
        "IMSc- Phd Programme"
    ],
    "5": [
        "Junior Research Fellowship",
        "Research Associates"
    ],
    "6": [],
    "7": [
        "Coffee Board",
        "Tea Board",
        "Rubber Board",
        "Spice board",
        "APEDA",
        "MPEDA"
    ],
    "8": [
        "Swachh Bharat Mission Gramin"
    ],
    "9": [
        "Deen Dayal Disabled Rehabilitation Scheme",
        "Assistance to Disabled Persons for Purchase, Fitting of Aids, Appliances",
        "National Fellowship for Students with Disabilities",
        "National Overseas Scholarship for students with disabilities",
        "Scholarship for Top Class Education for students with disabilities",
        "National Action Plan for skill development for persons with disabilities",
        "Incentives to private sector employers for providing employment to persons with disabilities",
        "Pre-matric scholarship for Persons with disabilities",
        "Post-matric Scholarship for Persons with Disabilities",
        "Free Coaching for Students with Disabilities"
    ],
    "10": [
        "Prime Ministers Scholarship Scheme PMSS",
        "Raksha Mantri Ex-servicemen Welfare Fund (RMEWF)"
    ],
    "11": [
        "Fertilizer Subsidy Scheme"
    ],
    "12": [
        "Atal Pension Yojana",
        "Varishtha Pension Bima Yojana",
        "Pradhan Mantri Vaya Vandana Yojana"
    ],
    "13": [
        "Pradhan Mantri Matsya Sampada Yojana"
    ],
    "14": [
        "Direct Cash Transfer for food grains",
        "DBT Kind - PDS operations in 34 states and UTs"
    ],
    "15": [
        "Janani suraksha yojana",
        "ASHA incentives",
        "Family Planning Compensation schemes",
        "Payments to contractual staff",
        "Janani Shishu Suraksha Karyakram",
        "NIKSHAY - Tribal TB Patients",
        "NIKSHAY - DOT Provider Honorarium",
        "NIKSHAY - TB Notification incentive for Private Sector",
        "NIKSHAY - TB patient incentive for nutritional support",
        "Ayushman Bharat -Pradhan Mantri Jan Arogya Yojana (AB-PMJAY)",
        "NationalCovid-19 Vaccination Programme "
    ],
    "16": [
        "FellowshipProgrammes Under The Human Resource Development For HealthResearch",
        "ICMR-JuniorResearch Fellowship",
        "ICMR-Post DoctoralFellowship",
        "ICMR-ShortTerm Studentship"
    ],
    "17": [
        "PradhanMantri Uchchatar Shiksha Protsahan (PM -USP) Central SectorScheme of Scholarship for College and Universitystudents",
        "Ishan UdaySpecial Scholarship Scheme for North Eastern Region",
        "P. G.Scholarship for Professional Courses for SC/STcandidates",
        "P.G. IndiraGandhi Scholarship For Single Girl Child",
        "P.G.Scholarship for University Rank Holders",
        "JuniorResearch Fellowship in Science, Humanities and SocialSciences",
        "SwamiVivekananda Single Girl Child Fellowship for Research inSocial Sciences",
        "BSRFellowship",
        "Post-DoctoralFellowship for SC/ST Candidates",
        "Dr SRadhakrishnan Postdoctoral Fellowship in Humanities andSocial Science",
        "PostDoctoral Fellowship for Women",
        "Dr D SKothari Post Doctoral Fellowship",
        "EmeritusFellowship",
        "P.G.Scholarship for GATE/GPAT qualified students for pursuingM.Tech/ M.E./M.Pharma- UGC",
        "PragatiScholarship for girls in Degree Colleges",
        "PragatiScholarship for girls Diploma Institutes",
        "Sakshamscholarship for differently abled students of DegreeColleges",
        "Sakshamscholarship for differently abled students of DiplomaInstitutes",
        "PradhanMantri Uchchatar Shiksha Protsahan (PM -USP) SpecialScholarship Scheme for Jammu & Kashmir andLadakh",
        "QIP for facultydeputed for M.Tech/ Ph.D studies at QIP Centers",
        "PradhanMantri Uchchatar Shiksha Protsahan (PM -USP) Central SectorInterest Subsidy Scheme",
        "P.G. ScholarshipFor GATE/GPAT Qualified Students For Pursuing M.Tech/M.E./M.Pharma - AICTE",
        "NationalDoctoral Fellowship (NDF)",
        "Programmefor Apprenticeship",
        "IndianKnowledge Systems",
        "AICTE -Swanath Scholarship Scheme - Degree",
        "AICTE -Swanath Scholarship Scheme - Diploma",
        "SavitribaiJyotirao Phule Fellowship for Single Girl Child"
    ],
    "18": [
        "Swatantrata sainiksamman pension scheme",
        "Grant in aidto Tripura and Mizoram for Rehabilitation of Brumigrants",
        "Relief andRehabilitation assistance to Sri Lankan refugees in therefugees camps",
        "Census of India2021 and Updation of National Population Register",
        "Enhanced compensation to 1984 Sikh Riots"
    ],
    "19": [
        "PrimeMinister scholarship scheme",
        "Central Scheme forAssistance to Civilian Victims (CSACV)"
    ],
    "20": [
        "Security relatedexpenditure - Relief and rehabilitation of Kashmirimigrants",
        "PM Assistance toDPs of POJK",
        "Relief andRehabilitation for Migrants and repatriates"
    ],
    "21": [
        "PardhanMantri Bhartiya Jan Aushadhi Pariyojana (PMBJP)",
        "Scholarshipto NIPER Students"
    ],
    "22": [
        "Counselling,Retraining and redeployment Scheme",
        "Scheme ofResearch, Development and Consultancies on Generic issues ofPublic Sector Enterprises"
    ],
    "23": [
        "Deen DayalUpadhyay Grameen Kaushalya Yojna",
        "Pradhan Mantri AwasYojna Grameen",
        "Mahatma GandhiNREGA",
        "IndiraGandhi National Old Age Pension Scheme- IGNOAPS",
        "IndiraGandhi National Widow Pension Scheme-IGNWPS",
        "IndiraGandhi National Disability Pension Scheme-IGNDPS",
        "DAY-NRLM",
        "NationalFamily Benefit Scheme"
    ],
    "24": [
        "NationalMeans-cum-Merit Scholarship Scheme",
        "NationalScheme of Incentive to Girls for SecondaryEducation",
        "Stipend forDisabled girls under IEDSS component of SamagraShiksha",
        "SamagraShiksha (interventions of uniform/text books)",
        "Pradhan MantriPoshan Shakti Nirman (PM-POSHAN)",
        "Kind Benefitunder IEDSS component of Samagra Shiksha"
    ],
    "25": [
        "DishaProgramme for women in science",
        "Alliance andR and D Mission - INSPIRE Award",
        "Alliance andR and D Mission - INSPIRE Scholarship",
        "Alliance andR and D Mission - INSPIRE Fellowship",
        "Alliance andR and D Mission - INSPIRE Faculty Award",
        "Alliance andR and D Mission - INSPIRE Internship"
    ],
    "26": [
        "PromotingInnovations in Individuals Start-ups and MSMEs-PRISM",
        "National Sand T Human Resource Development",
        "TechnologyDevelopment Utilization Program for Women"
    ],
    "27": [
        "Pre-MatricScholarship Scheme for Scheduled Castes and Others",
        "Centrally SponsoredScheme Of Post Matric Scholarships To The Students BelongingTo Scheduled Castes For Studies In India",
        "CentralSector Scheme of National Fellowship for providingscholarships to Scheduled Caste students to pursueprogrammes in Higher Education such as M.Phil. andPh.D.",
        "PM YASASVI -Post-Matric Scholarship to OBC, EBC and DNT",
        "PM YASASVI -Pre-Matric Scholarship to OBC, EBC and DNT",
        "CentralSector Scheme of National Fellowship for OBCStudents",
        "CentralSector Scheme of Free Coaching for SC and OBCStudents",
        "NAMASTE",
        "Centrally SponsoredScheme For Implementation Of Protection Of Civil Rights Act1955 And Scheduled Castes And Scheduled Castes And ScheduledTribes (Prevention Of Atrocities Act, 1989)",
        "Scheme ofGrant-in-aid to Voluntary and other Organisations workingfor Scheduled Castes",
        "Dr AmbedkarCentral Sector Scheme of Interest Subsidy on EducationalLoans for Overseas Studies for Other Backward Classes (OBCs)and Economically Backward Classes (EBCs)",
        "Central SectorScheme of Assistance for Prevention of Alcoholism aAndSubstance (Drugs) Abuse and for Social DefenceServices",
        "IntegratedProgramme for Older Persons",
        "CentralSector Scheme Of Top Class Education For SCStudents",
        "Vanchit Ikai Samuhaur Vargon ki Arthik Sahayata (VISVAS) Yojana",
        "NationalOverseas Scholarship (NOS)",
        "PM DAKSHScheme",
        "Scholarshipfor PM care Children",
        "CentralSector Scheme of Top Class College Education for OBC, EBCand DNT Students",
        "CentralSector Scheme of Top Class School Education for OBC, EBC andDNT Students",
        "PradhanMantri Anusuchit Jati Abhyuday Yojana"
    ],
    "28": [
        "MasterControl Facility - Scholarships and Stipends",
        "Indian SpaceResearch Organization Headquarters - Scholarships andStipends",
        "ISROPropulsion Complex - Scholarships and Stipends",
        "SatishDhawan Space Centre-SHAR - Scholarships andStipends",
        "ISROTelemetry, Tracking and Command Network - Scholarships andStipends",
        "UR Rao Satellite Centre-Scholarships and Stipends",
        "LiquidPropulsion Systems Centre - Scholarships andStipends",
        "VikramSarabhai Space Centre - Scholarships and Stipends",
        "Space Applications Centre - Scholarships and Stipends",
        "NationalRemote Sensing Centre - Scholarships and Stipends",
        "Indian Institute of Remote Sensing - Scholarships and   Stipends",
        "Indian Institute of Space Science and Technology -   Assistanceship and Fellowships"
    ],
    "29": [
        "KheloIndia",
        "Assistanceto National Sports Federations",
        "Scheme forHuman Resource Development in Sports",
        "SportsAuthority of India",
        "LakshmibaiNational Institute of Physical Education",
        "Nationalwelfare fund for sportspersons",
        "Nationalsports development fund",
        "Special cashawards to medal winners in international sportsevents",
        "Pension tomeritorious sportspersons"
    ],
    "30": [
        "R and DProgramme in Water Sector"
    ],
    "31": [
        "NationalYouth Corps",
        "YouthHostels",
        "IC-InternationalYouth Exchange Programmes",
        "Assistance toScouting and Guiding Organizations",
        "RGNIYD-Academic,Training and Capacity Building Programmes",
        "RGNIYD-Scholarshipsto Students"
    ],
    "32": [
        "Rashtriya AyurvedaVidyapeeth",
        "NationalAYUSH Mission - Medicines under AYUSH Services",
        "Promotion ofInternational Co-operation in AYUSH"
    ],
    "33": [
        "Award ofScholarships to Young Artists in different culturalfields",
        "Award ofJunior Fellowship to Outstanding Artistes/Persons in theField of Culture",
        "Award ofTagore National Fellowship for Cultural Research",
        "Scheme forPension and Medical Aid to Artistes",
        "RepertoryGrant",
        "CulturalFunction and Production Grant",
        "Financial Assistance to Cultural Organisations with National   Presence",
        "Award ofSenior Fellowship to Outstanding Artistes/Persons in thefield of Culture"
    ],
    "34": [
        "Scheme ofNorth Eastern Council of Financial Support to the Student ofNorth East Region"
    ],
    "35": [
        "PolarScience And Cryospher- PACER",
        "Research,Education and Training Outreach - REACHOUT"
    ],
    "36": [
        "Reimbursementof training fees under Scheduled Caste Sub Plan Tribal subPlan",
        "FutureSkillsPRIME (Programme for Re-skilling/Up-skilling of IT Manpowerfor Employability)",
        "Visvesvaraya PhD Scheme for Electronics and IT Phase II"
    ],
    "37": [
        "Green India MissionNational Afforestation Programme",
        "ProjectTiger",
        "ProjectElephant",
        "IntegratedDevelopment of Wild Life Habitats"
    ],
    "38": [
        "ICCRScholarship"
    ],
    "39": [
        "Demand IncentiveDelivery Mechanism under FAME India Scheme",
        "Issue of GSTConcession Certificate on purchase of Car by PhysicallyHandicapped Persons"
    ],
    "40": [
        "Credit LinkSubsidy Scheme (CLSS)",
        "DAYNULM",
        "STATE AND UTGRANTS UNDER PMAY URBAN",
        "SwachhBharat Mission Urban",
        "PM STREET VENDORATMANIRBHAR NIDHI (PM SVANidhi)"
    ],
    "41": [
        "JournalistWelfare Scheme",
        "Scholarship SchemeOf Satyajit Ray Film And Television InstituteKolkata"
    ],
    "42": [
        "EmployeesPension Scheme for EPF Pensioners",
        "Grants to VV GiriNational Labour Institute (VVGNLI)",
        "Grants to DattopantThengdi National Board for Workers Education and Development(DTNBWED)",
        "RehabilitationAssistance under the Scheme of Rehabilitation of BondedLabour",
        "Stipend toDifferently Abled Candidates under the Scheme of VocationalRehabilitation Centres for Handicapped",
        "Stipend to Traineesunder the Scheme of Welfare of SC ST Job-Seekers throughCoaching, Guidance and Vocational Training",
        "Stipend to Childrenin the Special Schools under the National Child LabourProject (NCLP)",
        "Revised IntegratedHousing Scheme (RIHS)-2016 for Beedi, IOMC,LSDM,CINEWorkes",
        "FamilyPension-cum-Life Assurance and Deposit Linked InsuranceSchemes for the Plantation Workers in Assam",
        "FinancialAssistance for Education for the Wards of Beedi, Cine, IOMC,LSDM Workers",
        "EmployeesPension Scheme for EPF Members",
        "PradhanMantri Shram Yogi Maan-dhan (PM-SYM)",
        "NationalPension Scheme for Traders and Self Employed Persons[erstwhile Pradhan Mantri Laghu Vyapari Maan-dhan (PM-LVM)Yojana]",
        "National Databasefor Unorganised Workers"
    ],
    "43": [
        "PMEGP PrimeMinisters Employment Generation Programme",
        "MMDA Grant to KhadiInstitutions",
        "SFURTI- SI",
        "IC Schemes",
        "Entrepreneurshipand Skill Develoment Programme (ESDP)",
        "NationalAwards",
        "Coir VikasYojana",
        "ATI Scheme(Training Component)",
        "PMVishwakarma"
    ],
    "44": [
        "Skill DevelopmentInitiatives",
        "Maulana AzadNational Fellowship for Minority Student",
        "Merit-cum-Means based Scholarship for professional and Technicalcourse for minorities",
        "Pre- MatricScholarship for Minorities",
        "Post-MatricScholarship for Minorities",
        "Nai Udaan-Support for minority students clearing prelims conducted byUPSC, SSC, State Public Service Commissions and StaffSelection Commission",
        "Upgradingthe Skills and Training in traditional Arts Crafts forDevelopment (USTTAD)",
        "FreeCoaching Allied Scheme for Minorities",
        "NaiRoshni",
        "Nai Manzil",
        "PadhoPredesh - Interest subsidy on educational loans for OverseasStudies",
        "Begum HazratMahal National Scholarship Scheme",
        "Scheme for containing population decline of small minority   community",
        "PMVIKAS CommittedLiabilities"
    ],
    "45": [
        "NationalRenewable Energy Fellowship Programme and National SolarScience Fellowship Programme",
        "New NationalBiogas and Organic Manure Programme (NNBOMP)",
        "Off-grid andDecentralized Solar PV Applications Programme",
        "Gridconnected Roof-top Solar Projects implemented on anindividual house of capacity of 3 kW and ab",
        "Fellowshipcomponent of R and D projects sponsored by theMinistry",
        "Short TermTraining Programme component of HRD Programme",
        "Pradhan MantriKisan Urja Suraksha evam Utthaan Mahabhiyan Scheme",
        "PM-SURYAGHAR MUFT BIJLI YOJANA"
    ],
    "46": [
        "PAHAL",
        "Pradhan MantriUjjwala Yojana",
        "DBT-K"
    ],
    "47": [
        "PrimeMinister's Scholarship Scheme for Railway Protection Force(RPF)"
    ],
    "48": [
        "NationalApprenticeship Promotion Scheme",
        "SkillAcquisition and Knowledge Awareness for Livelihood Promotion(SANKALP)",
        "PradhanMantri Kaushal Vikas Yojana"
    ],
    "49": [
        "Stipend tostudents in Indian Statistical Institute",
        "Fellowshipto research scholars in Indian StatisticalInstitute"
    ],
    "50": [
        "PowerloomGroup Workshed Scheme",
        "Scheme forIn-situ Upgradation of Plain Powerloom",
        "Scheme forDevelopment of Silk Industry",
        "SamarthScheme",
        "ComprehensiveHandicrafts Cluster Development Programme",
        "Raw MaterialSupply Scheme",
        "AmendedTechnology Upgradations Fund",
        "PradhanMantri Credit Scheme for Powerloom Weavers",
        "Human ResourceDevelopment (HRD) And Promotional Activities Scheme-Training Programme in Scientific sheep rearing/ artificialinsemination /Manufacturing of woollen items/machineshearing etc.",
        "National Handloom Development Programme",
        "National Handicrafts Development Programme",
        "Price Support Operation for Cotton Procurement by CCI"
    ],
    "51": [
        "CapacityBuilding for Service Providers"
    ],
    "52": [
        "Pre-MatricScholarship Scheme for ST students",
        "Post-MatricScholarship Scheme for ST students",
        "NationalFellowship and Scholarship for Higher education for STstudents (for FELLOWSHIP)",
        "NationalFellowship and Scholarship for higher education for STstudents (for SCHOLARSHIP)",
        "NationalOverseas Scholarship Scheme",
        "Institutional Support for Development and Marketing of Tribal   Product",
        "Vocational Training Centres in Tribal Areas",
        "Scheme ofDevelopment of Particularly Vulnerable TribalGroups",
        "Scheme of Grant inAid to Voluntary Organizations working for welfare ofSTs"
    ],
    "53": [
        "Anganwadi Services- Honorarium to AWW and AWH",
        "Anganwadi Services- Supplementary Nutrition Program",
        "Scheme forAdolescent Girls",
        "PALNA- Honorariumto Workers",
        "PALNA- Facilitiesto Beneficiaries",
        "MissionVatsalya-Salary of staff",
        "Shakti Sadan -(Swadhar and Ujjawala) - Salary",
        "Shakti Sadan -(Swadhar and Ujawala) - Facilities to beneficiaries",
        "PradhanMantri Matru Vandana Yojana",
        "AnganwadiServices - Training Program",
        "One Stop Centre -(payment of Salary of Staff)",
        "Mission Vatsalya-Facilities to Beneficiaries",
        "Mission Vatsalya -Facilities to Beneficiaries (Sponsorship)"
    ]
}


@app.route('/schemes/<int:department_id>', methods=['GET'])
def get_schemes(department_id):
    department_id_str = str(department_id)
    if department_id_str in storage_dictionary:
        return jsonify({
            'department_id': department_id_str,
            'schemes': storage_dictionary[department_id_str]
        })
    else:
        return jsonify({
            'error': 'Department ID not found'
        }), 404

if __name__ == '__main__':
    app.run(debug=True,port=5001)
    
