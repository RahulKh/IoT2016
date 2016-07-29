/*
Copyright [2016] [Danish Shaikh]

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

package esper;
import java.io.FileWriter;
import java.io.IOException;
import java.util.HashMap;
import java.util.Map;
import java.util.Map.Entry;
import java.util.Random;
import java.util.stream.IntStream;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.slf4j.bridge.SLF4JBridgeHandler;

import com.espertech.esper.client.Configuration;
import com.espertech.esper.client.EPServiceProvider;
import com.espertech.esper.client.EPServiceProviderManager;
import com.espertech.esper.client.EPStatement;
import com.espertech.esper.client.EventBean;

import de.uniluebeck.itm.util.logging.Logging;


public class Main {
	static {
		setupLogging();
	}

	/**
	 * @param args
	 */
	/**
	 * @param args
	 */
	public static void main(String[] args) {
		Logger log = LoggerFactory.getLogger(Main.class);
		Configuration esperClientConfiguration = new Configuration();

		// Setup Esper and define a message Type "ipEvent"
		EPServiceProvider epServiceProvider = EPServiceProviderManager.getDefaultProvider(esperClientConfiguration);
		{
			Map<String, Object> eventDef = new HashMap<>();
			eventDef.put("isp", String.class);
			eventDef.put("DevMac", String.class);
			eventDef.put("jittery", int.class);
			eventDef.put("DevBand", int.class);
			eventDef.put("bandwidth", String.class);
			eventDef.put("keyword", String.class);
			eventDef.put("ip",String.class);

			epServiceProvider.getEPAdministrator().getConfiguration().addEventType("ipEvent", eventDef);
		}

		// Create listener to trigger events
		{
			String expression = "select keyword, bandwidth,ip,DevBand,DevMac, count(bandwidth) as counter "
					+ "from ipEvent.win:time(10 seconds) group by bandwidth, keyword,ip,DevBand,DevMac";

			EPStatement epStatement = epServiceProvider.getEPAdministrator().createEPL(expression);

			Map<String, Long> latestSentimentToCountMap = new HashMap<>();

			epStatement.addListener((EventBean[] newEvents, EventBean[] oldEvents) -> {
				if (newEvents == null || newEvents.length < 1) {
					log.warn("Received null event or length < 1: " + newEvents);
					return;
				}
		
				
				EventBean event = newEvents[0];

				String key = (String) event.get("keyword") + "-" + (String) event.get("bandwidth")+ "-"+(String) event.get("ip");
				latestSentimentToCountMap.put(key, (Long) event.get("counter"));
				
				if ((int) event.get("DevBand")>500)
				{
					
					log.info("Alert!!");
				String 	tmpvar = ("DeviceMacAddress| "+((String)event.get("DevMac"))+ " |Throttled :" +((int) event.get("DevBand")*.75));
					log.info(tmpvar); 
					try {
						writeFile(tmpvar+ System.lineSeparator());
					} catch (IOException e) {
						// TODO Auto-generated catch block
						e.printStackTrace();
					}
				}
				
				log.info("--------------------------------------------------------------");
				for (Entry<String, Long> entry : latestSentimentToCountMap.entrySet())
			
					log.info("ISP {} = {}", entry.getKey(), entry.getValue());

			});

			epStatement.start();
		}

		// Stimulated data
		{
			String bandwidths[] = { "High_Bandwidth", "Meduim_Bandwidth", "Low_bandwidth" }; //TRIGGER CERTAIN VALUE
			String ispOptions[] = {"BELL","ROGERS","BEANFIELD","TEKSAVVY"};

			Random r = new Random();

			IntStream.range(1, 100).forEach(i -> {
				// Create Hash Map
				Map<String, Object> ipEvent = new HashMap<>();
				ipEvent.put("id", r.nextInt(10000));
				ipEvent.put("Latency", r.nextInt(1000));
				ipEvent.put("Jitter", r.nextInt(1000));
				ipEvent.put("DevMac",randMac());
				ipEvent.put("DevBand", r.nextInt(1000));
				ipEvent.put("SigStr", r.nextInt(1000));
				ipEvent.put("ip",randIP(0,225));
				ipEvent.put("MACAP", 172);
				ipEvent.put("messageText", "Bla " + r.nextInt());
				ipEvent.put("bandwidth", bandwidths[r.nextInt(bandwidths.length)]);
				ipEvent.put("keyword", ispOptions[r.nextInt(ispOptions.length)]);

				epServiceProvider.getEPRuntime().sendEvent(ipEvent, "ipEvent");

				try {
					Thread.sleep(r.nextInt(1000));
				} catch (Exception e) {
					e.printStackTrace();
				}
			});
		}

	}
	public static String randMac()
	{
		String dm="";
		Random r = new Random();
		for (int i=0 ; i<6;i++)
		{
		int tmpInt = (r.nextInt((15 - 0) + 1) + 0);
		dm = dm + (Integer.toHexString(tmpInt));
		tmpInt = (r.nextInt((15 - 0) + 1) + 0);
		dm = dm + (Integer.toHexString(tmpInt));
		dm = dm + ":";
		}
		return (dm);
	}
	public static String randIP (int min,int max)
	{
		Random r = new Random();
		
		String ip= (Integer.toString(r.nextInt((max - min) + 1) + min)+"."+Integer.toString(r.nextInt((max - min) + 1) + min)+"."+Integer.toString(r.nextInt((max - min) + 1) + min)+"."+Integer.toString(r.nextInt((max - min) + 1) + min));
		return (ip);
	}
	
	public static void writeFile (String Content) throws IOException
	{
		FileWriter fw = new FileWriter("/home/clayfox/workspace2/esper-demo/Alerts.log",true);
		fw.write(Content);
		fw.close();
	}

	public static void setupLogging() {
		// Optionally remove existing handlers attached to j.u.l root logger
		SLF4JBridgeHandler.removeHandlersForRootLogger(); // (since SLF4J 1.6.5)

		// add SLF4JBridgeHandler to j.u.l's root logger, should be done once during
		// the initialization phase of your application
		SLF4JBridgeHandler.install();

		Logging.setLoggingDefaults();
	}

}

